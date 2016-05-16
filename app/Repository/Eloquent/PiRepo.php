<?php

namespace Repository\Eloquent;

use Mail,
    Validator,
    Crypt,
    Request,
    Input,
    Schema,
    Response,
    File,
    DateTime,
    stdClass,
    Debugbar,
    Uuid,
    DB,
    Hash,
    Auth,
    Session;
use Repository\PaymentInstructionInterface;
use App\Models\PurchaseOrder;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Attachment;
use App\Models\Discounting;
use App\Models\PaymentInstruction;
use App\Models\Notification;

class PiRepo implements PaymentInstructionInterface {

    public $buyerId = "";
    public $sellerId = "";
    public $userId;
    public $piId = "";
    public $piUuid;
    public $keywords;
    public $statusArray = [];
    //public $startDate;
    //public $endDate;
    public $uuid = "";
    public $bankData = "";
    public $userType = "";
    public $companyConf = "";
    public $variousStates = "";
    public $success = false;
    public $sellerIDis = false;
    public $cashDate = false;
    public $dataDateWise = false; //flag for if date is selected
    public $requestPayment = false; //set true if request payement button pressed
    public $startDate = "";
    public $endDate = "";
    public $finalStatus = array();
    public $checkDiscounting = false;
    public $isPiLimit = false;
    public $bankDis = false;
    public $statusId = "";
    public $discountingId = "";
    public $remarks = "";
    public $isPagiante = false;
    public $dashboardData = false;
    public $message;
    public $loggedInUser;
    /* View List Of PI */

    public function getData() {
       // DB::enableQueryLog();
        $max_dis_days = $this->bankData['basic_configuration']['max_dis_days'];
        $min_dis_days = $this->bankData['basic_configuration']['min_dis_days'];

        if (!$this->cashDate)//if date is not set by user then use todays date
            $this->cashDate = date('Y-m-d');

        if ($this->dataDateWise) { //this is for approved payment from min dis days and mx dis days.
            $minDate = date('Y-m-d'); //start date is todays date
            $maxDate = $this->cashDate; //end date is selected date   
        } else if ($this->sellerIDis) { //this is for payment expected to selected date data
            $minDate = date("Y-m-d", strtotime("+$min_dis_days days", strtotime($this->cashDate))); //start date is multiples of min dis days
            $maxDate = date("Y-m-d", strtotime("+$max_dis_days days", strtotime($this->cashDate))); //end date is multiples of max dis days
        }

        $piData = DB::table('pi_view as pv')
                ->join('company_band_view as cv', function ($join) {
                    $join->on('pv.seller_id', '=', 'cv.seller_id')->on('pv.buyer_id', '=', 'cv.buyer_id');
                })
                ->select('pv.*', 'cv.*', DB::raw('DATEDIFF(pv.due_date,"' . $this->cashDate . '") as discounting_days,(pv.pi_net_amount*cv.discounting)/100 as discounted_amount'));
        if ($this->sellerIDis)
            $piData = $piData->whereNotIn('pv.pi_id', function($query) {
                $query->select('pi_id')
                        ->from(with(new Discounting)->getTable())
                        ->whereNotIn('status', [2, 4, 6]); //if record  is rejected or internal rejected then should be avoid.
            });
        if ($this->sellerIDis)//this flag is set in SellerIDiscounting controller  
            $piData = $piData->whereBetween('pv.due_date', [$minDate, $maxDate]);

        if ($this->sellerId || $this->userType == 'seller') {
            $piData->where('pv.seller_id', $this->sellerId);
            $piData->where('pv.pi_status', '1');
        } elseif ($this->buyerId || $this->userType == 'buyer') {
            $piData->where('pv.buyer_id', $this->buyerId);
        }

        if ($this->statusArray) {
            $piData->whereIn('pv.pi_status', $this->statusArray);
        }

        if ($this->keywords) {
            $piData->where(function ($piData) {
                $key = $this->keywords;
                $piData->where('cv.buyer_name', 'like', "%$key%");
                $piData->orWhere('cv.seller_name', 'like', "%$key%");
                $piData->orWhere('pv.invoice_number', 'like', "%$key%");
            });
        }

        if ($this->startDate && $this->endDate) {
            $date1 = saveDate($this->startDate);
            $date2 = saveDate($this->endDate);
            $piData->whereRaw('date(pv.due_date) >=?', [$date1]);
            $piData->whereRaw('date(pv.due_date) <=?', [$date2]);
        }

        if ($this->dashboardData){
             return $piData->selectRaw('FLOOR(sum((pv.pi_net_amount*cv.discounting)/100)) as sumDiscountedAmount')
                          ->lists('sumDiscountedAmount');
           // dd(DB::getQueryLog(),$minDate,$maxDate,$this->sellerId,$this->buyerId);                
        }


        $piData->orderBy('due_date', 'DESC');
        

        if($this->isPagiante)
        	return $piData->paginate(15);

       // dd(DB::getQueryLog(),$minDate,$maxDate,$this->sellerId,$this->buyerId);
        return $piData->get();
    }

    public function getPiDetails() {
        $piData = DB::table('pi_view as pv')
                ->join('company_band_view as cv', function ($join) {
                    $join->on('pv.seller_id', '=', 'cv.seller_id')->on('pv.buyer_id', '=', 'cv.buyer_id');
                })
                ->leftJoin('purchase_orders as po', 'pv.po_id', '=', 'po.id')
                ->select('pv.*', 'cv.*', DB::raw('DATEDIFF(pv.due_date,CURDATE()) as discounting_days,(pv.pi_net_amount*cv.discounting)/100 as discounted_amount'), 'po.payment_terms', 'po.delivery_address');
        if ($this->piUuid) {
            $piData = $piData->where('pv.pi_uuid', $this->piUuid);
        }
        if ($this->piId) {
            $piData = $piData->where('pv.pi_id', $this->piId);
        }
        if ($this->sellerId) {
            $piData = $piData->where('pv.seller_id', $this->sellerId);
        }
        if ($this->buyerId) {
            $piData = $piData->where('pv.buyer_id', $this->buyerId);
        }
        $piData = $piData->first();
        $piData->bankCharge = $bankCharge = $this->bankChargeCalculation($piData->discounted_amount, $piData->manualDiscounting, $piData->discounting_days);
        $piData->interestPercentage = $interestPercentage = $this->discountPercentage($bankCharge, $piData->discounted_amount);
        $piData->items = $inItemData = InvoiceItem::where('invoice_id', $piData->invoice_id)->get();
        $itemJson = json_encode($inItemData, true);
        $piData->attachments = $attachData = Attachment::where('type_id', $piData->invoice_id)
                ->where('type', 'invoice')
                ->where('status', '0')
                ->get();
        return $piData;
        /*$attachJson = json_encode($attachData);
        $piData = json_encode($piData);
        $jsonDta = '{"pi":' . $piData . ',"items":' . $itemJson . ',"attachments":' . $attachData . ',"interestPercentage":"' . $interestPercentage . '"}';
        return json_decode($jsonDta, true);*/
    }

    /* Insert PI and make Apprved Invoice */

    public function store($request) {
        $notification = new NotificationRepo();
        $rules = array('sub_total' => 'required', 'tds' => 'required', 'final_amount' => 'required', 'seller_id' => 'required', 'invoice_id' => 'required');
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('buyer.invoice.view')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $this->success = true;

            $pi = new PaymentInstruction();

            $invData = Invoice::select('due_date', 'id','uuid','invoice_number','seller_id')->where('uuid', $request->invoice_id)->first();

            $tds_amount = ($request->sub_total * $request->tds) / 100;

            $pi->invoice_id = $invData->id;
            $pi->buyer_id = $this->buyerId;
            $pi->seller_id = $this->getId('companies', $request->seller_id)->id;
            $pi->amount_less_tax = $request->sub_total;
            $pi->tds_percentage = $request->tds;
            $pi->tds_amount = $tds_amount;
            $pi->net_pi_amount = $request->final_amount;
            $pi->payment_due_date = $invData->due_date;
            $pi->uuid = Uuid::generate();
            $pi->status = 1;

            $pi_number = DB::select('call getPiNumber(' . $pi->invoice_id . ',' . $this->buyerId . ')');

            $pi->pi_number = $pi_number[0]->pi;


            $pi->save();
            
            $sellerConf = Company::find($pi->seller_id);
            $sellerConf = json_decode($sellerConf->configurations,true);

                if ($sellerConf['seller']['other_configuration']['auto_discounting'] == 1) {
                   
                    $discountData = new stdClass;
                    $discountData->payment_date = date('Y-m-d');
                    $discountData->invoice_id = $invData->uuid;

                    $discountData->pi_id = $pi->uuid;
                
                    $this->storeDiscounting($discountData);
                }

            /*Notification For Approve Invoice*/
                $notificationArray['object_id'] = $invData->id;
                $notificationArray['object_type'] = 'invoice';
                $notificationArray['text'] = "Your invoice $invData->invoice_number is approved";
                $notificationArray['from_id'] = $this->userId;
                $notificationArray['company_id'] = $invData->seller_id;
                $d = $notification->saveNotification($notificationArray);

            $this->message = "Your invoice No $invData->invoice_number is approved"; 

            $invData = Invoice::where('uuid', $request->invoice_id)
                        ->update(['status' => '5','updated_by' => $this->loggedInUser]);

            return $this->success;
        }
    }

    /* Insert Discounting */

    public function storeDiscounting($request) {
        
        $invoice = Invoice::select('due_date')->where('uuid', $request->invoice_id)->first();
        $payment_date = strtotime($request->payment_date);
        $due_date = strtotime($invoice->due_date);
        
        $diffDays = ($due_date - $payment_date) / (60 * 60 * 24);
        
        $minDays = $this->bankData['basic_configuration']['min_dis_days'];

        $maxDays = $this->bankData['basic_configuration']['max_dis_days'];

        //dd($diffDays,$minDays,$maxDays,$due_date,$payment_date,$request->invoice_id,$invoice->due_date,$request->payment_date);

        if ($minDays > $diffDays || $maxDays < $diffDays) {
            return redirect()->route('seller.piListing.view')
                            ->with('errorMessage', 'Payment date is not valid.');
        } else {
            $otherCharges = json_encode($this->bankData['discounting_fees']);
            $this->piUuid = $request->pi_id;
            
            $piData = $this->getPiDetails();
            $baseRate = $this->bankData['basic_configuration']['bank_base_rate'];
            $eligibleAmount = $piData->discounted_amount;
            $eligiblePercentage = $piData->discounting;
            $bankCharge = $this->bankChargeCalculation($eligibleAmount, $eligiblePercentage, $diffDays);
            $discountRate = $this->discountPercentage($bankCharge, $eligibleAmount);
            $expectedInterest = $this->interestCalculation($eligibleAmount, $eligiblePercentage, $diffDays);
            $discountObj = new Discounting();
            $discountObj->uuid = Uuid::generate();
            $discountObj->created_by = $this->loggedInUser;
            $discountObj->pi_id = $piData->pi_id;
            $discountObj->loan_amount = $eligibleAmount;
            $discountObj->interest_percentage = $discountRate;
            $discountObj->expected_interest = $expectedInterest;
            $discountObj->other_charges = $otherCharges;
            $discountObj->eligibility_percentage = $eligiblePercentage;
            $discountObj->loan_date = date('Y-m-d', strtotime($request->payment_date));

            if($this->sellerId){
                if ($this->companyConf['maker_checker']['manual_discoutning'] == 1 && !(\Entrust::can('seller.iDiscounting.approve'))) {
                    $discountObj->status = 0;
                } elseif ($this->companyConf['maker_checker']['manual_discoutning'] == 0 || (\Entrust::can('seller.iDiscounting.approve'))) {
                    $discountObj->status = 1;
                }
            } elseif($this->buyerId){
                $discountObj->status = 0;
            }

            if(($this->bankData['maker_checkers']['discounting_request_approval']==1) && $discountObj->status == 1){
               $discountObj->status = 5; 
            }

            /*$sellerConf = Company::find($piData->seller_id);
            $sellerConf = json_decode($sellerConf->configurations,true);
                if ($sellerConf['seller']['maker_checker']['manual_discoutning'] == 1 && !(\Entrust::can('seller.iDiscounting.approve'))) {
                    $discountObj->status = 0;
                } elseif ($sellerConf['seller']['maker_checker']['manual_discoutning'] == 0 || (\Entrust::can('seller.iDiscounting.approve'))) {
                    $discountObj->status = 1;
                }*/
            
            $this->success = $discountObj->save();

            if ($this->success)
                $message = 'success';
           
           
            return $message;
        }
    }

    public function getId($table, $uuid) {
        $byrData = DB::table($table)
                ->select('id')
                ->where('uuid', $uuid)
                ->first();
        return $byrData;
    }

    public function getBankCharge($data) { //bank charge data
        $bankCharge = array();
        if (is_object($data)) {
            return $finalAmt = $this->bankChargeCalculation($data->discounted_amount, $data->manualDiscounting, $data->discounting_days);
        }
        foreach ($data as $val) {
            $finalAmt = $this->bankChargeCalculation($val->discounted_amount, $val->manualDiscounting, $val->discounting_days);
            array_push($bankCharge, $finalAmt);
        }

        return $bankCharge;
    }

    public function getDataDateWise() {
        $this->dataDateWise = true;
        return $this->getData();
    }

    public function otherCharges($disAmount) { // calculating other charges from bank
        $sum = 0;

        foreach ($this->bankData['discounting_fees'] as $value) {  //get all discount fees of bank
            if ($value['type'] == 'value') {
                $sum = $sum + $value['value'];
            } else {
                $sum = $sum + ($disAmount * $value['value'] / 100);
            }
        }
        return $sum;
    }

    public function interestCalculation($eligibleAmount, $manualDiscounting, $t) { //calculating interest
        $baseRate = $this->bankData['basic_configuration']['bank_base_rate']; // banks base rate
        $n = $this->bankData['basic_configuration']['compoundFrequency']; // banks base rate
        $i = ($baseRate + $manualDiscounting) / 100;
        
        $finalAmount = $eligibleAmount * pow((1 + ($i / $n)), ($n * $t / $n));
        return ($finalAmount - $eligibleAmount);
    }

    public function bankChargeCalculation($disAmount, $manualDiscounting, $disDays) {
        $otherCharges = $this->otherCharges($disAmount);
        $totalInterestAmount = $this->interestCalculation($disAmount, $manualDiscounting, $disDays);
        $finalAmt = $otherCharges + $totalInterestAmount;
        return $finalAmt;
    }

    public function getrequestPayment($piId) {
        $len = count($piId);
        $bankChargeSum = $discountRateSum = 0;
        foreach ($piId as $key => $piId) {
            $this->piUuid = $piId;
            $data = $this->getPiDetails();
            if (Input::has('selectedDate') && Input::has('dueDate')) {
                $dueDate = Input::get('dueDate');
                $discountingDays = round((strtotime($data->due_date) - strtotime(Input::get('selectedDate'))) / (60 * 60 * 24));
            } else {
                $discountingDays = $data->discounting_days;
            }
            $bankCharge = $this->bankChargeCalculation($data->discounted_amount, $data->manualDiscounting, $discountingDays);
            $bankChargeSum += $bankCharge;
            $interest_percentage = round(($bankCharge / $data->discounted_amount) * 100, 2);
            $discountRateSum += $interest_percentage;
            
        }
        $minDisDays = $this->bankData['basic_configuration']['min_dis_days'];
        $maxDisDays = $this->bankData['basic_configuration']['max_dis_days'];
        $finalData = array('bankChargeSum' => $bankChargeSum / $len, 'discountRateSum' => $discountRateSum / $len, 'minDisDays' => $minDisDays, 'maxDisDays' => $maxDisDays,'manualDiscounting' => $data->manualDiscounting);
        return $finalData;
    }

    public function postRequestPayment($request) {
        $reqobj = new stdClass;
        DB::beginTransaction();
        try {
            foreach ($request->pi_id as $key => $value) {
               // dd($request->pi_id[$key]);
                //dd($value);
                $reqobj->pi_id = $value;
                $reqobj->payment_date = $request->payment_date;
                $reqobj->invoice_id = $request->invNumber[$key];
                $this->storeDiscounting($reqobj);
               // dd($reqobj->payment_date);
            }
            DB::commit();
            $message = 'success';
        } catch (\Exception $e) {
            DB::rollback();
            $message = 'error';
            // something went wrong
        }
        return $message;
    }

    public function discountPercentage($bankCharge, $eligibleAmount) {
        return round(($bankCharge / $eligibleAmount) * 100, 2);
    }

    public function uploadPi($request) { //upload pi csv file
        $file = $request->pi_file;
        $allowed = array('text/plain', 'application/csv', 'application/vnd.ms-excel');
        $rules = array('pi_file' => 'required');
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $mime = $file->getMimeType();
            if (in_array($mime, $allowed)) {
                $this->success = true;
                $filePath = $file->getPathName();
                $fileName = $file->getClientOriginalName();
                $data = $this->importCsv($filePath);
            } else {
                return redirect()->back()
                                ->withErrors("Invalid File!")
                                ->withInput();
            }
        }
    }

    public function savePiUpload($data) {
        //dd($data);
        $pi = new PaymentInstruction();
        $dateArray = explode("/", $data[6]);
        $dueDate = $dateArray[2] . "-" . $dateArray[1] . "-" . $dateArray[0];
        $cmpData = Company::select('id')->where('name', $data[0])->first();
        $invData = Invoice::select('due_date', 'id', 'uuid')->where('invoice_number', $data[1])->first();
        
        if (!empty($cmpData->id)) {
            DB::beginTransaction();
            try{
                if (empty($data[1])) {
                    $invoice_id = "";
                    $invoice_uuid = "";

                } elseif (empty($invData->id)) {
                    $uuid = Uuid::generate();
                    $inv = new Invoice();
                    $inv->invoice_number = $data[1];
                    $inv->uuid = $uuid;
                    $inv->amount = $data[2];
                    $inv->final_amount = $data[2];
                    $inv->due_date = $dueDate;
                    $inv->due_date = $dueDate;
                    $inv->buyer_id =  $this->buyerId;
                    $inv->seller_id = $cmpData->id;
                    $inv->discount = 0;
                    $inv->discount_type = 0;
                    $inv->created_by = $this->loggedInUser;
                    $inv->save();
                    $invoice_id = $inv->id;
                    $invoice_uuid = $uuid;
                    //dd($invoice_id,$invoice_uuid);
                } else {
                    $invoice_id = $invData->id;
                    $invoice_uuid = $invData->uuid;
                    
                }

                $pi->invoice_id = $invoice_id;
                $pi->buyer_id = $this->buyerId;
                $pi->seller_id = $cmpData->id;
                $pi->amount_less_tax = $data[2];
                $pi->tds_percentage = $data[3];
                $pi->tds_amount = $data[4];
                $pi->net_pi_amount = $data[5];
                $pi->pi_number = $data[7];
                $pi->payment_due_date = $dueDate;
                $pi->uuid = Uuid::generate();
                $pi->created_by = $this->loggedInUser;

                if ($this->companyConf['maker_checker']['pi_upload'] == 1 && !(\Entrust::can('buyer.piListing.approve'))) {
                    $pi->status = 0;
                } elseif ($this->companyConf['maker_checker']['pi_upload'] == 0 || (\Entrust::can('buyer.piListing.approve'))) {
                    $pi->status = 1;
                }
                $invData = Invoice::where('id', $invoice_id)
                        ->update(['due_date' => $dueDate, 'status' => '5','updated_by' => $this->loggedInUser]);

                $pi->save();
                
                $sellerConf = Company::find($cmpData->id);
                $sellerConf = json_decode($sellerConf->configurations,true);

                if (($sellerConf['seller']['other_configuration']['auto_discounting'] == 1) && $pi->status == 1) {
                   
                    $discountData = new stdClass;
                    $discountData->payment_date = date('Y-m-d');
                    $discountData->invoice_id = $invoice_uuid;

                    $discountData->pi_id = $pi->uuid;

                    $this->storeDiscounting($discountData);
                }

                DB::commit();

            return 1;

          }catch (\Exception $e) {
            DB::rollback();
            $jsonArray['error'] = 'error';
            $jsonArray['msg'] = $e;
           return $e;
         }
        }
        return 0;
    }

    public function importCsv($path) {
        $csv_file = $path;
        $insertedRecords = 0;
        $invalidRecordsArray = array();
        $displayRecords = 0;
        if (($handle = fopen($csv_file, "r")) !== FALSE) {
            fgetcsv($handle);
            $totalRecords = 0;
            $fp = file($csv_file);
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                for ($c = 0; $c < $num; $c++) {
                    $col[$c] = $data[$c];
                }
                $invalidRecords = $this->checkValidRecord($col);
                if ($invalidRecords) {
                    array_push($invalidRecordsArray, $invalidRecords[0]);
                }
                $totalRecords++;
            }
            $displayRecords = count($fp) - 1 - count($invalidRecordsArray);

            $this->downloadInvalidRecords($invalidRecordsArray);

            fclose($handle);

            $message = "PI " . $displayRecords . " Records inserted," . count($invalidRecordsArray) . " Records are Invalid.";
            Session::flash("uplaodMessage", $message);

            // exit;
        } else {
            echo "Error being upload file";
        }
    }

    public function checkValidRecord($col) {

        $errorString = "";
        $invalidRecords = array();
        $paymentDate = $col[6];
        if ($col[0] == '') {
            array_push($invalidRecords, $col);
            $errorString .= 'Empty Seller Name,';
        }

        if (!is_numeric($col[5])) {

            array_push($invalidRecords, $col);
            $errorString .= 'Invalid PI Amount,';
        }

        if ($col[6] == '') {
            array_push($invalidRecords, $col);

            $errorString .= 'Empty Payment Date,';
        } else {
            if (preg_match("/^(\d{2})\/(\d{2})\/(\d{4})$/", $paymentDate)) {
                //$paymentDate = date('d/m/Y', strtotime($col[6]));
                $matches = explode('/', $paymentDate);
                if (!checkdate($matches[1], $matches[0], $matches[2])) { // check if date, month and year is vaild or not
                    array_push($invalidRecords, $col);
                    $errorString .= 'Invalid Date Format,';
                }
            } else {
                array_push($invalidRecords, $col);
                $errorString .= 'Invalid Date,';
            }
        }

        if (count($invalidRecords) == 0) {

            $result = $this->savePiUpload($col);
            if ($result == 0) {
                array_push($invalidRecords, $col);
                $invalidRecords[0][8] = "Seller Name Does Not Exist";
                return $invalidRecords;
            }
        } else {
            $invalidRecords[0][8] = substr($errorString, 0, -1);
            return $invalidRecords;
        }
    }

    public function downloadInvalidRecords($dataArray) {
        if (!empty($dataArray)) {
            $root = base_path() . '/uploads/invalid_pi/';
            $file = 'InvalidRecordsReport_' . time() . '.csv';
            $filename = $root . $file;
            $handle = fopen($filename, 'w+');
            $data = array();

            fputcsv($handle, array('Seller Name*', 'Invoice No', 'Net Invoice Amount', 'TDS percent (%)', 'TDS Amount', 'PI Amount*', 'Payment Date(dd/mm/yyyy)*', 'PI Number', 'Error Type'));

            foreach ($dataArray as $row) {
               fputcsv($handle, array($row['0'], $row['1'], $row['2'], $row['3'], $row['4'], $row['5'], $row['6'], $row['7'], $row['8']));
            }

            fclose($handle);
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename=InvalidPiRecord_' . time() . '.csv');
            header('Pragma: no-cache');
            readfile($filename);
            Session::flash("filename", $file);
        }
    }

    public function getDiscountingRequest() {

        $iReqData = DB::table('idiscounting_request');
        //dd($iReqData);
        if (Input::has('search')) {
            $iReqData = $iReqData->where('invoiceNumber', Input::get('search'))
                    ->orWhere('buyerName', 'like',  "%". Input::get('search') . "%");
        }
        if ($this->finalStatus) {
            $iReqData = $iReqData->whereIn('status', $this->finalStatus);
        }
        if ($this->startDate && $this->endDate) {
            $iReqData->whereBetween('discountingDate', [$this->startDate, $this->endDate]);
        }

        if ($this->bankDis)
            $iReqData = $iReqData->whereNotIn('status', [0, 2]);

        if ($this->piId) {
            return $iReqData = $iReqData->where('pi_id', $this->piId)->first();
        } 
        if($this->isPagiante)
            return $iReqData = $iReqData->paginate(15);
        
         
        return $iReqData = $iReqData->get();
    }

    /* public function checkDiscountingStatus()
      {
      $iReqData = DB::table('idiscounting_request');
      if($this->checkDiscounting){
      $iReqData->where('pi_id', $this->piId)
      ->whereIn('status', ['3','5'])->first();
      }else{

      }
      } */

    public function statusID($status) {//loigc for status id according to rights and configuration
        if ($status == "Approved") {
            if ((\Entrust::can('bank.iDiscounting.postApprove')) || ($this->bankData['maker_checkers']['discounting_request_approval'] == "0"))
            // dd($status, \Entrust::can('bank.iDiscounting.postApprove'),$this->bankData['maker_checkers']['discounting_request_approval']);
                return 5;
            elseif ($this->bankData['maker_checkers']['discounting_request_approval'] == "1" && \Entrust::can('bank.iDiscounting.makerPostApprove'))//checker present
                return 3;//if checker present
        } elseif ($status == "Rejected") {
            if ((\Entrust::can('bank.iDiscounting.postApprove')) || ($this->bankData['maker_checkers']['discounting_request_approval'] == "0"))//checker not present
                return 6;
            elseif ($this->bankData['maker_checkers']['discounting_request_approval'] == "1" && \Entrust::can('bank.iDiscounting.makerPostApprove'))//checker present
                return 4; //if checker present
        }
    }

    public function changeStatus() {
        $this->success = Discounting::where('uuid', $this->discountingId)
                ->update(['status' => $this->statusId, 'reject_remark' => $this->remarks, 'updated_by' => $this->loggedInUser]);

        if ($this->success)
            return "success";
        else
            return "error";
    }

    /* public function updateStatus($request)
      {

      if($request->discountingId && $request->statusId){
      $this->success = Discounting::where('uuid', $request->discountingId)
      ->update(['status' => $request->statusId, 'reject_remark' => $request->remarks]);
      }

      if($this->success)
      return "success";
      else
      return "error";
      } */

    /* public function updateMultipleStatus()
      {
      if(Input::has('disUuid') && Input::has('disStatus')){
      $disUuid   = Input::get('disUuid');
      $disStatus = Input::get('disStatus');

      foreach ($disUuid as $key => $value) {
      if($this->bankDis){//if it is bank
      $disStatus = $this->statusID($request->statusId); //check statusid according to logic
      }
      $this->success = Discounting::where('uuid', $value)
      ->update(['status' => $disStatus]);
      }
      }

      if($this->success)
      return "success";
      else
      return "error";
      } */

    public function approvePi() {
        if (\Entrust::can('buyer.piListing.approve')) {
            $result = PaymentInstruction::where('uuid', $this->piUuid)
                    ->update(['status' => '1','updated_by' => $this->loggedInUser]);
            Session::flash("piStatusMessage", "Pi Approved Successfully");
            return $result;
        }
        return true;
    }

    public function rejectPi($request) {
        if (\Entrust::can('buyer.piListing.reject')) {
            $result = PaymentInstruction::where('uuid', $request->pi_id)
                    ->update(['status' => '2', 'reject_remark' => $request->remarks,'updated_by' => $this->loggedInUser]);
            Session::flash("piStatusMessage", "Pi Rejected Successfully");
            return $result;
        }
        return true;
    }

    public function bankDashboard(){
        $data['bankBuyerSeller'] = DB::table('companies')->count();
        $data['approvedLoan'] = DB::table('idiscounting_request')->whereIn('status',[5,7,8])->sum('loanAmount');
        $data['maturityLoan'] = DB::table('idiscounting_request')->whereRaw('(dueDate BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY))')->whereIn('status',[5,7,8])->sum('loanAmount');
        $data['pendingLoan'] = DB::table('idiscounting_request')->whereIn('status',[1,3])->sum('loanAmount');
        $data['lastTenLoan'] = DB::table('idiscounting_request as ID_R')
                ->join('companies as B_C','B_C.id','=','ID_R.buyer_id')
                ->join('companies as S_C','S_C.id','=','ID_R.seller_id')
                ->select('ID_R.*','B_C.name as buyerName','S_C.name as sellerName')
                ->whereIn('ID_R.status',[1,3])->take(10)->get();
        return $data;
    }
}

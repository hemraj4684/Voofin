<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Repository\Eloquent;
use Repository\InvoiceInterface;
use App\Models\Invoice;
use App\Models\Attachment;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\InvoiceItem;
use App\Models\Notification;
use Validator,
    DB,
    Uuid,
    Schema;

class InvoiceRepo implements InvoiceInterface{

    public $userId;
    public $buyerId;
    public $sellerId;
    public $userType;
    public $invoiceLimit;
    public $uuid;
    public $isApi = false;
    public $isSingle = false;
    public $success = false;
    public $deleteAttachment = false;
    public $deleteInvoice = false;
    public $invoiceId;
    public $keywords;
    public $companyConf;
    public $folder;
    public $startDate;
    public $endDate;
    public $statusArray = [];
    public $loggedInUser;

    public function getInvoices() {
        return $this->getData();
    }

    public function getInvoiceByAttibute() {
       return $this->getData();
    }

    public function getData() {
        $query = Invoice::leftJoin('purchase_orders', 'purchase_orders.id', '=', 'invoices.purchase_order_id');
        $query->Join('companies as buyer', 'buyer.id', '=', 'invoices.buyer_id');
        $query->Join('companies as seller', 'seller.id', '=', 'invoices.seller_id');
        $query->select('invoices.*', 'purchase_orders.purchase_order_number', 'purchase_orders.uuid as poUuid', 'purchase_orders.final_amount as poAmount','purchase_orders.delivery_address');
        $query->addSelect('buyer.name as buyerName', 'buyer.uuid as buyerUuid','buyer.address as buyerAddress');
        $query->addSelect('seller.name as sellerName', 'seller.uuid as sellerUuid','seller.address as sellerAddress');
        $query->whereNull('purchase_orders.deleted_at');
        if ($this->sellerId) {
            $query->where('invoices.seller_id', $this->sellerId);
        }
        if ($this->buyerId) {
            $query->Join('band_configurations as band',function ($join) {
                         $join->on('band.seller_id','=','invoices.seller_id')->on('band.buyer_id','=','invoices.buyer_id');
                       });
            $query->addSelect('band.tax_percentage');
            $query->where('invoices.buyer_id', $this->buyerId);
        }
        if ($this->statusArray) {
            $query->whereIn('invoices.status', $this->statusArray);
        }
        if ($this->keywords) {
            $query->where(function ($query) {
                $key = $this->keywords;
                $query->where('seller.name', 'like', "$key%");
                $query->orWhere('buyer.name', 'like', "$key%");
                $query->orWhere('purchase_orders.purchase_order_number', 'like', "$key%");
                $query->orWhere('invoices.invoice_number', 'like', "$key%");
            });
        }
        if ($this->startDate && $this->endDate) {
            $date1 = saveDate($this->startDate);
            $date2 = saveDate($this->endDate);
            $query->whereRaw('date(invoices.created_at) >=?', [$date1]);
            $query->whereRaw('date(invoices.created_at) <=?', [$date2]);

        }
        if ($this->uuid) {
            $query->where('invoices.uuid', $this->uuid);
            $result = $query->first();      
            $result->invoiceItems;
            $this->invoiceId = $result->id;
            $result->invoiceAttachments = $this->getAttachments();

            return $result;
        }
        if ($this->invoiceId) {
            $query->where('invoices.id', $this->invoiceId);
            $result = $query->first();
            $result->invoiceItems;
            $result->invoiceAttachments = $this->getAttachments();
            return $result;
        }
        if ($this->invoiceLimit) {
             $result = $query->take($this->invoiceLimit)->get();
             return $result;
        }


        if ($this->isApi)
            return $query->get();
        
        $result = $query->paginate(15);
        return $result;
    }

    /*public function getItems() {
       return "hello world";
      } */

    public function getAttachments() {
        $invoiceAttachmentData = Attachment::where('type_id', $this->invoiceId)
                ->where('type', 'invoice')
                ->where('status', '0')
                ->get();
        return $invoiceAttachmentData;
    }

    /* invoice validation */

    public function validateInvoice($request) {
        $required = "";
        $flag = 1;
        $jsonArray['error'] = 'error';
        $jsonArray['msg'] = INVOICE_INVALID_DATA_MSG;
        if (isset($request->invoice_number)) {
            $required = 'required';
        }

        $rules = array('invoice_number' => $required, 'buyer_name' => 'required', 'in_due_date' => 'required','amount' => 'required','final_amount' => 'required', 'currency' => 'required');
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messaages = $validator->messages();
            foreach ($rules as $key => $val) {
                $jsonArray[$key . 'Err'] = $messaages->first($key);
            }
           $flag = 0;
        } 
        if($request->amount==0){
           $jsonArray['amountErr'] = "Subtotal of items cant be zero";
           $flag = 0;
        }
        if($request->final_amount==0){
           $jsonArray['final_amountErr'] = "Total amount cant be zero";
           $flag = 0;
        }
        if(!$this->validateInvoiceNumber($request)){
           $jsonArray['invoice_numberErr'] = "Invoice number already exist for this seller";
           $flag = 0;
        }
        if($flag==1) {
            $invoiceNumber = $this->store($request);
            $jsonArray['error'] = 'success';
            $jsonArray['msg'] = $invoiceNumber;
            
        }
        return $jsonArray;
    }

    /* insert invoice and invoice items */
    public function store($request) {
    $notification = new NotificationRepo();
    $flag = 0;
     DB::beginTransaction();
     try{
            $this->success = true;
            $inputs = $request->all();

            $bId = $this->getId('companies', $inputs['buyer_uuid'])->id;

            if (isset($inputs['invoice_uuid']) && $inputs['invoice_uuid']) {
                $invoiceId = $this->getId('invoices', $inputs['invoice_uuid'])->id;
                $invoice = Invoice::find($invoiceId);
                $invoice->updated_by = $this->loggedInUser;
                $deleteItems = InvoiceItem::where('invoice_id', '=', $invoice->id)->delete();
                $message = " updated successfully";
            } else {
                $invoice = new Invoice();
                $invoice->uuid = Uuid::generate();
                $invoice->created_by = $this->loggedInUser;
                $message = " created successfully";
                $flag = 1;
            }

            $invoicesColumns = Schema::getColumnListing('invoices');

            /* this block is for editing of invoice starts here */

            $taxArray = array();
            $taxSum = 0;
            if(isset($inputs['tax_type'])){
            foreach ($inputs['tax_type'] as $key => $val) {
                if (!empty($inputs['tax_type']) && !empty($inputs['tax'][$key]) && !empty($inputs['tax_value'][$key])) {
                    $taxArr = array();
                    $name = explode(":", $inputs['tax_type'][$key]);
                    $taxArr['name'] = $name[0];
                    $taxArr['percentage'] = $inputs['tax'][$key];
                    $taxArr['value'] = $inputs['tax_value'][$key];
                    $taxSum = $taxSum + $taxArr['value'];
                    array_push($taxArray, $taxArr);
                }
            }
            }
            $taxJson = json_encode($taxArray);
            
            foreach ($inputs as $key => $value) {
                if (in_array($key, $invoicesColumns)) {
                    $invoice->$key = $value;
                }
            }

            if ($this->companyConf['maker_checker']['invoice_creation'] == 1 && !(\Entrust::can('seller.invoice.approve'))) {
                $invoice->status = 0;
            } elseif ($this->companyConf['maker_checker']['invoice_creation'] == 0 || (\Entrust::can('seller.invoice.approve'))) {
                $invoice->status = 1;
            }

            /* checke if po is exist or not */
            if(isset($inputs['po_no']) && (!empty($inputs['po_no']))){
                $poQuery = PurchaseOrder::select('id')
                        ->where('buyer_id', $bId)
                        ->where('purchase_order_number', $inputs['po_no'])
                        ->first();
                
                if (is_null($poQuery)) {
                    $poAdd = new PurchaseOrder();
                    $poAdd->uuid = Uuid::generate();
                    $poAdd->purchase_order_number = $inputs['po_no'];
                    $poAdd->buyer_id = $bId;
                    $poAdd->seller_id = $this->sellerId;
                    $poAdd->status = 3;
                    $poAdd->save();
                    $this->poId = $poAdd->id;
                } else {
                    $this->poId = $this->getId('purchase_orders', $inputs['po_id'])->id;
                }
                $invoice->purchase_order_id = $this->poId;
           }
            /* checke if po is exist or not end */
            
            $invoice->due_date = saveDate($inputs['in_due_date']);
            
            $invoice->buyer_id = $bId;
            $invoice->seller_id = $this->sellerId;
            $invoice->tax_amount = $taxSum;
            $invoice->tax_details = json_encode($taxArray);

            $invoice->save();

            
            /* Add More Items */
            if(isset($inputs['item'])){
                foreach ($inputs['item'] as $k => $v) {
                    if (!empty($inputs['item'][$k])) {
                        $itemData = array(
                            'invoice_id' => $invoice->id,
                            'name' => $inputs['item'][$k],
                            'description' => $inputs['description'][$k],
                            'unit_price' => $inputs['price_per'][$k],
                            'quantity' => $inputs['quantity'][$k],
                            'total' => $inputs['total'][$k],
                        );
                        $result = InvoiceItem::insert($itemData);
                    }
                }
            }
            /* Add Attachment */
            if(isset($inputs['invoice_attach']))
               $this->uploadAttachment($request, $invoice->id);

             $message = "Invoice ".$invoice->invoice_number.$message;

             /*Notification Insertion For Creat Invoice*/
             if(($flag == 1) && ($this->companyConf['maker_checker']['invoice_creation'] == 0 || (\Entrust::can('seller.invoice.approve')))){
                $notificationArray['object_id'] = $invoice->id;
                $notificationArray['object_type'] = 'invoice';
                $notificationArray['text'] = "You have Recived New invoice of ৳".number_format($inputs['final_amount'],2)." that need your attention";
                $notificationArray['from_id'] = $this->userId;
                $notificationArray['company_id'] = $bId;
                $notificationResult = $notification->saveNotification($notificationArray);
             }

             DB::commit();

             return $message;
          
        }catch (\Exception $e) {
            DB::rollback();
            $jsonArray['error'] = 'error';
            $jsonArray['errorMsg'] = $e;
           return $e;
        }
    
    }

    /* upload attachment start */

    public function uploadAttachment($request, $invoiceId = null) {
        $inputs = $request->all();
        $destPath = base_path() . '/uploads/' . $this->folder . '/';
        $allowedExt = array('image/png',
            'image/jpeg',
            'image/gif',
            'image/bmp',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel',
        );
        if (isset($inputs['jfiler-items-exclude-invoice_attach-0'])) {
            $removedFiles = json_decode($inputs['jfiler-items-exclude-invoice_attach-0'], true);
        } else {
            $removedFiles = array();
        }
        if ($invoiceId == null) {
            $invoiceId = $this->getId('invoices', $inputs['invoice_uuid'])->id;
        }
        foreach ($inputs['invoice_attach'] as $file) {
            if ($file != null && !empty($file->getClientOriginalName())) {
                $imageName = $file->getClientOriginalName();
                if (!in_array($imageName, $removedFiles)) {
                    $ext = $file->getClientOriginalExtension();
                    $mime = $file->getMimeType();

                    if (in_array($mime, $allowedExt)) {

                        $imageName = "invoice_" . uniqid() . "." . $ext;
                        if ($file->move($destPath, $imageName)) {
                            $fileData = array(
                                'name' => $imageName,
                                'path' => $destPath,
                                'type' => "invoice",
                                'type_id' => $invoiceId,
                            );

                            $result = Attachment::insert($fileData);
                        } //end of file upload
                    } //allowed mime end
                } //avoide removed files
            } //avoid null files
        } //end of foreach
    }
    /* delete invoice and attachment start */
    public function deleteInvoiceData() {
        if ($this->deleteAttachment) {
            $attData = Attachment::where('id', $this->uuid)
                    ->update(['status' => '1']);
            return $attData;
        }
        if ($this->deleteInvoice) {
            $invData = Invoice::where('uuid', $this->uuid)->delete();

            return $invData;
        }
    }
    /* delete invoice and attachment end */

    /* upload attachment end */
    public function approveInvoice() {

        $jsonArray['error'] = 'error';
        $jsonArray['msg'] = "Something Went wrong";
        $queryData = $this->getData();

        if(!$queryData)
            return $jsonArray;

        if ($this->buyerId) {
            if ($this->companyConf['maker_checker']['invoice_approval'] == 1) {
                $status = "3";
            } elseif ($this->companyConf['maker_checker']['invoice_approval'] == 0) {
                $status = "5";
            }

            $invData = Invoice::where('uuid', $this->uuid)
                        ->update(['status' => $status, 'updated_by' => $this->loggedInUser]);

         } elseif ($this->sellerId) {
            $date = strtotime($queryData->created_at);
            $now = time();
            $diffDay = round(($now - $date) / 86400);
            $dueDate = date('Y-m-d', strtotime("+" . $diffDay . "days", strtotime($queryData->due_date)));

            $invData = Invoice::where('uuid', $this->uuid)
                                ->update(['status' => 1, 'due_date' => $dueDate, 'created_at' => date('Y-m-d H:i:s'), 'updated_by' => $this->loggedInUser]);
        }
        if($invData){
                $jsonArray['error'] = 'success';
                $jsonArray['msg'] = "Invoice ".$queryData->invoice_number." Approved Successfully";
        }
        return $jsonArray;
    }
    /* approve invoice end */

    /* reject invoice start */
    public function rejectInvoice($request) {
        $jsonArray['error'] = 'error';
        $jsonArray['msg'] = "Something Went wrong";
        $this->uuid=$request->invoice_uuid;
        $queryData = $this->getData();
        $notification = new NotificationRepo();
        if(!$queryData)
            return $jsonArray;

        if ($this->buyerId) {
            if ($this->companyConf['maker_checker']['invoice_approval'] == 1 && !(\Entrust::can('buyer.invoice.checker'))) {
                $status = "4";
            } elseif ($this->companyConf['maker_checker']['invoice_approval'] == 0 || (\Entrust::can('buyer.invoice.checker'))) {
                $status = "6";
            }
           /*Notification For Reject Invoice*/ 
            $notificationArray['object_id'] = $queryData->id;
            $notificationArray['object_type'] = 'invoice';
            $notificationArray['text'] = "Your invoice ".$queryData->invoice_number." is rejected";
            $notificationArray['from_id'] = $this->userId;
            $notificationArray['company_id'] = $queryData->seller_id;
            $notificationResult = $notification->saveNotification($notificationArray);

        } elseif($this->sellerId) {
            $status = "2";
        }
        
        $invData = Invoice::where('uuid', $request->invoice_uuid)
            ->update(['status' => $status, 'reject_remark' => $request->remarks, 'updated_by' => $this->loggedInUser]);

        if($invData){
                $jsonArray['error'] = 'success';
                $jsonArray['msg'] = "Invoice $queryData->invoice_number Rejected Successfully";
        }

        return $jsonArray;
    }
    /* reject invoice end */

    public function validateInvoiceNumber($request) {
        $invoiceNumber = $request->invoice_number;
        $data = Invoice::select('id')
                ->where('seller_id', $this->sellerId)
                ->where('invoice_number', $invoiceNumber)
                ->first();
        
        if (!empty($data->id)) {
            return 0;
        }
        return "true";
    }

    public function getId($table, $uuid) {
        $byrData = DB::table($table)
                    ->select('id')
                    ->where('uuid', $uuid)
                    ->first();
        return $byrData;
    }

    public function summaryDashboard(){
  
        if($this->statusArray){
            $result = Invoice::whereIn('invoices.status', $this->statusArray);
            if($this->sellerId){
                $result->where('seller_id',$this->sellerId);
            }
            if($this->buyerId){
                $result->where('buyer_id',$this->buyerId);
            }
   
            return $result->sum('final_amount');
        }

    }

    public function getStausPieChart(){
            if($this->sellerId){
                $queryCondition ='AND seller_id = '.$this->sellerId;
            }
            if($this->buyerId){
                $queryCondition ='AND buyer_id = '.$this->buyerId;
            }
            if($this->statusArray){
                $arrayString = implode(",", $this->statusArray);
                $queryCondition .=' AND status IN ('.$arrayString.')';
            }

            $sql = "SELECT t1.status,t1.status_count, (t1.status_count/t2.total_status)*100 as 'percentage_of_status', t1.invoice_amount FROM (SELECT COUNT(*) as status_count,SUM(final_amount) as invoice_amount, status FROM `invoices` WHERE deleted_at is NUll $queryCondition GROUP BY status) as t1 CROSS JOIN (SELECT COUNT(*) as total_status FROM `invoices` WHERE deleted_at is NUll $queryCondition) as t2";
            
            $result =  DB::select($sql);
            return $result;
    }

    public function getNotifications(){
            $query = Notification::select('notifications.*')->where('to_id',$this->toId);
            if($this->objectType == 'invoice'){
              $query->addSelect('invoices.uuid as invoice_uuid');
              $query->join('invoices','invoices.id','=','object_id');
            }elseif($this->objectType == 'po'){
              $query->addSelect('po.uuid as po_uuid');
              $query->join('purchase_orders as po','po.id','=','object_id');
            }
            $result =  $query->get();
            return $result;
    }




}

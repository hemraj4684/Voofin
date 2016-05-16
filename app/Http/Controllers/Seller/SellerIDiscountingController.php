<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use Auth,Input,URL,DateTime,Session;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\PaymentInstructionInterface;

class SellerIDiscountingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $piRepo;

    public function __construct(PaymentInstructionInterface $piRepo)
    {
        $this->piRepo = $piRepo;
        $this->piRepo->bankData = loadJSON('results');
        $this->currencyData = loadJSON('Common-Currency');
        $this->piRepo->variousStates = loadJSON('variousStatus');
        $this->piRepo->sellerId = session('company_id');
        $this->piRepo->userType = session('typeUser');
        $this->piRepo->companyConf = json_decode(session('company_conf'),TRUE);
        $this->piRepo->companyConf = $this->piRepo->companyConf[$this->piRepo->userType];
        $this->piRepo->loggedInUser  = session('userId');
    }

    public function requestPayment()
    {
        $finalData = $this->piRepo->getrequestPayment(Input::get('piId'));
        $finalData['invoiceAmt'] = Input::get('invoiceAmt');
        $finalData['piAmt'] = Input::get('piAmt');
        $finalData['piId'] = Input::get('piId');
        $finalData['dueDate'] = Input::get('dueDate');
        $finalData['invNumber'] = Input::get('invNumber');
        $finalData['eligibleAmt'] = Input::get('eligibleAmt');

        if(Input::has('selectedDate') && Input::has('maxDueDate')){
            $finalData['balanceAmt'] = $finalData['piAmt'] - $finalData['eligibleAmt'] - $finalData['bankChargeSum'];
            return $finalData;
        }
        else{
            /*$requestPayment['invoiceAmt'] = Input::get('invoiceAmt');
            $requestPayment['piAmt'] = Input::get('piAmt');
            $requestPayment['eligibleAmt'] = Input::get('eligibleAmt');*/
            return view('seller.iDiscounting.piModal',compact('requestPayment','finalData'));
        }
    }
    public function postRequestPayment(Request $request)
    {
        $message = $this->piRepo->postRequestPayment($request);
        return redirect()->route('seller.iDiscounting.view')->with('message', $message);
    }
    public function showPiModal($id)
    {
        $this->piRepo->piUuid = $id;
        $currencyData = $this->currencyData;
        $piData = $this->piRepo->getPiDetails();
        //dd($piData);
        $statusData['status'] = $this->piRepo->variousStates['INVOICE']['Seller'];
        $statusData['symbols'] = $this->piRepo->variousStates['SYMBOLS'];
        return view('seller.iDiscounting.piModal',compact('piData','currencyData','statusData'));
    }

    public function index()
    {
        $this->piRepo->sellerIDis = true;
        if(Input::has('cashDate')){
            $this->piRepo->cashDate = Input::get('cashDate');//if date is enter
            $this->piRepo->cashDate = date("Y-m-d",strtotime($this->piRepo->cashDate));//for database date style
        }

        $iDisData = $this->piRepo->getData();//this data is between min and max payment days 
        //if()
        $iDisBankChargeData = $this->piRepo->getBankCharge($iDisData);
        $currencyData = $this->currencyData;
        //dd($iDisData,$currencyData);
        
        $todayDate = date('Y-m-d');
        if(Input::has('cashDate')){
            if($this->piRepo->cashDate > $todayDate){
                $iDisDateData = $this->piRepo->getDataDateWise();//this data is between todays date to selected date
                // dd($iDisDateData,$iDisData);
            }

        }

        return view('seller.iDiscounting.iDiscounting',compact('iDisBankChargeData','iDisData','currencyData','iDisDateData','Input'));
    }


    public function getDiscountingRequest() 
    {

        if (Input::has('invoiceDate')) {
            $dates = explode('-', Input::get('invoiceDate'));
            $this->piRepo->startDate = saveDate($dates[0]);
            $this->piRepo->endDate   = saveDate($dates[1]);
           // dd($this->piRepo->startDate,$this->piRepo->endDate);
        }
        
        if(Input::has('invoiceStatus')){
            $finalStatus = $temp = array();
            $invoiceStatus = Input::get('invoiceStatus');
            foreach ($invoiceStatus as $key => $value) {
                $temp = array_keys($this->piRepo->variousStates['DISCOUNTING']['Seller'], $value);
                
                foreach ($temp as $key => $value) {
                    array_push($this->piRepo->finalStatus, $value);    
                }
                
            }
        }

        $this->piRepo->isPagiante = TRUE;
        $iReqData = $this->piRepo->getDiscountingRequest();
        foreach ($iReqData as $key => $value) {
            $disDays = (strtotime($value->dueDate)- strtotime($value->discountingDate))/(60*60*24);
            $bankCharge[] = $this->piRepo->bankChargeCalculation($value->loanAmount,$value->manualDiscounting,$disDays);    
        }
        //dd($bankCharge);
        //$iReqData = $this->piRepo->bankChargeCalculation(); 
        //$iReqData = $this->piRepo->getBankCharge($iReqData);
        $statusData['status'] = $this->piRepo->variousStates['DISCOUNTING']['Seller'];
        $statusData['symbols'] = $this->piRepo->variousStates['SYMBOLS'];

        if(\Entrust::can('seller.iDiscounting.postApprove'))
            $approveRejectButton = "Y";
        else
            $approveRejectButton = "N";

        return view('seller.discountingRequest.discountingRequestListing',compact('iReqData','statusData','bankCharge','approveRejectButton'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDiscounting(Request $request)
    {
        $message = $this->piRepo->storeDiscounting($request);
        return redirect()->route('seller.iDiscounting.view')->with('message', $message);
    }

    /*public function getApprove()
    {
        $message = $this->piRepo->updateMultipleStatus();
        return response()->json(['status'=>$message]);      
        //return redirect()->route('seller.discountingRequestListing.view');
    }*/

    public function postApprove(Request $request)
    {
        //////////////////////////////////////
        $this->piRepo->statusId = $request->statusId;

        if($request->remarks)
           $this->piRepo->remarks = $request->remarks; 

        if(is_array($request->discountingId)){
            foreach ($request->discountingId as $key => $value) {
               $this->piRepo->discountingId =  $value;
               $message = $this->piRepo->changeStatus();
            }
        } else{
            $this->piRepo->discountingId =  $request->discountingId;
            $message = $this->piRepo->changeStatus();
        }

        if($request->ajax())    
          return response()->json(['status'=>$message]);      

        return redirect()->route('seller.discountingRequestListing.view');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

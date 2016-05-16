<?php

namespace App\Http\Controllers\Bank;

use Illuminate\Http\Request;
use Auth,Input,URL,DateTime,Session;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\PaymentInstructionInterface;

class BankDiscountingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(PaymentInstructionInterface $piRepo)
    {
        $this->piRepo = $piRepo;
        $this->piRepo->bankData = loadJSON('results');
        $this->currencyData = loadJSON('Common-Currency');
        $this->piRepo->variousStates = loadJSON('variousStatus');
        $this->piRepo->loggedInUser  = session('userId');
    }

    public function index()
    {
        $this->piRepo->bankDis = true;
        $statusData['status']  = $this->piRepo->variousStates['DISCOUNTING']['Bank'];
        $statusData['symbols'] = $this->piRepo->variousStates['SYMBOLS'];
        //dd(Input::get('invoiceStatus'));
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
                $temp = array_keys($statusData['status'], $value);
                
                foreach ($temp as $key => $value) {
                    array_push($this->piRepo->finalStatus, $value);    
                }
                
            }
        }

        $iReqData = $this->piRepo->getDiscountingRequest();
        
        foreach ($iReqData as $key => $value) {
            $disDays = (strtotime($value->dueDate)- strtotime($value->discountingDate))/(60*60*24);
            $bankCharge[] = $this->piRepo->bankChargeCalculation($value->loanAmount,$value->manualDiscounting,$disDays);    
        } 

        if(\Entrust::can('bank.iDiscounting.makerPostApprove') || \Entrust::can('bank.iDiscounting.postApprove'))
          $approveRejectButton = "Y";
        else
          $approveRejectButton = "N";
            
        return view('bank.discountingRequest.discountingRequestListing',compact('iReqData','bankCharge','statusData','approveRejectButton'));
    }

    public function getApprove()//for multiple status
    {
        $this->piRepo->bankDis = true;
        $message = $this->piRepo->updateMultipleStatus();
        return response()->json(['status'=>$message]);      
        //return redirect()->route('seller.discountingRequestListing.view');
    }

    public function postApprove(Request $request)
    {
        //dd($this->piRepo->statusID($request->statusId));

        $this->piRepo->statusId = $this->piRepo->statusID($request->statusId);

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

        if($request->ajax()){    
          return response()->json(['status'=>$message]);      
        }
        
        return redirect()->route('bank.discountingRequest.view');
    }



  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

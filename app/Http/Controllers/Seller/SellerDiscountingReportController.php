<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use Auth,Input,URL,DateTime,Session,Excel;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\PaymentInstructionInterface;

class SellerDiscountingReportController extends Controller
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
        $this->piRepo->sellerId = session('company_id');
        $this->piRepo->userType = session('typeUser');
        $this->piRepo->companyConf = json_decode(session('company_conf'),TRUE);
        $this->piRepo->companyConf = $this->piRepo->companyConf[$this->piRepo->userType];
        
    }

    public function index()
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

        if(!Input::has('excelButton'))
            $this->piRepo->isPagiante = TRUE;

        $iReqData = $this->piRepo->getDiscountingRequest();
        
        foreach ($iReqData as $key => $value) {
            $disDays = (strtotime($value->dueDate)- strtotime($value->discountingDate))/(60*60*24);
            $bankCharge[] = $this->piRepo->bankChargeCalculation($value->loanAmount,$value->manualDiscounting,$disDays);    
        }
        
        $statusData['status'] = $this->piRepo->variousStates['DISCOUNTING']['Seller'];
        $statusData['symbols'] = $this->piRepo->variousStates['SYMBOLS'];
        $currencyData = $this->currencyData;   

        if(Input::has('excelButton')){
            Excel::create('sellerDiscoutingExcel', function($excel) use($iReqData, $statusData, $bankCharge, $currencyData){
                $excel->sheet('sellerDiscouting', function($sheet)  use($iReqData, $statusData, $bankCharge, $currencyData){
                    $sheet->loadView('seller.reports.sellerDiscountingUsageReportExcel',compact('iReqData','statusData','bankCharge','currencyData'));
                });
            })->export('csv');
        }
        
        return view('seller.reports.sellerDiscountingReportListing',compact('iReqData','statusData','bankCharge','currencyData'));
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

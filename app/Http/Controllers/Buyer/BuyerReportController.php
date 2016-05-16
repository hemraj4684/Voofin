<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;

use Auth,Input,URL,Excel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\PaymentInstructionInterface;
use Repository\ReportInterface;

class BuyerReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $piRepo;
    public $reportRepo;

    public function __construct(ReportInterface $reportRepo,PaymentInstructionInterface $piRepo)
    {
        $this->piRepo = $piRepo;
        $this->reportRepo = $reportRepo;
        $this->piRepo->buyerId = session('company_id');
        $this->piRepo->roleId = session('role_id');
        $this->piRepo->userType = session('typeUser');
        $this->piRepo->companyConf = json_decode(session('company_conf'),TRUE);
        $this->piRepo->companyConf = $this->piRepo->companyConf[$this->piRepo->userType];
        $this->reportRepo->buyerId = session('company_id');
        $this->reportRepo->roleId = session('role_id');        
        $this->reportRepo->companyConf = json_decode(session('company_conf'),TRUE);
        $this->reportRepo->companyConf = $this->reportRepo->companyConf[session('typeUser')];
        $this->variousStates = loadJSON('variousStatus');
        $this->currencyData = loadJSON('Common-Currency');
        $this->piRepo->bankData = loadJSON('results');
        
    }

    public function getPiReport(Request $request)
    {
        if($request->input('piDate')){
          $date = explode("-",$request->input('piDate'));
          if(count($date)>1){
              $this->piRepo->startDate = $date[0];
              $this->piRepo->endDate = $date[1]; 
          } 
        }
        if($request->input('piStatus')){
           $searchArray = array();
           $inputArray = $request->input('piStatus');
           $statusArray = $this->variousStates['PI']['Buyer'];
           foreach($statusArray as $key => $value){
             if(in_array($value,$inputArray)){
                array_push($searchArray,$key);
            }
           }
           $this->piRepo->statusArray = $searchArray;  
          
        }
        if($request->input('search')){
           $this->piRepo->keywords = $request->input('search');
        }

        if(!Input::has('excelButton'))
            $this->piRepo->isPagiante = TRUE;
        
        $piData = $this->piRepo->getData();
        $currencyData=$this->currencyData;
        $statusData = $this->variousStates;
        $statusData['status'] = $this->variousStates['PI']['Buyer'];
        $statusData['symbols'] = $this->variousStates['SYMBOLS'];

        if(Input::has('excelButton')){
            Excel::create('buyerPIExcel', function($excel) use($piData, $statusData){
                $excel->sheet('buyerPIExcel', function($sheet)  use($piData, $statusData){
                    $sheet->loadView('buyer.reports.piReportExcel',compact('piData', 'statusData'));
                });
            })->export('csv');
        }

        return view('buyer.reports.piReportListing',compact('piData','currencyData','statusData'));
    }
    public function discountingUsageReport(Request $request)
    {
        $this->reportRepo->isDiscounting = true;
        $querystringArray = Input::only(['search']);
        $this->reportRepo->piStatusArray = [1, 3, 4];
        $this->reportRepo->discountingStatusArray = [5, 7, 8];
        $this->reportRepo->keywords = $request->input('search');
        
        if(Input::has('excelBtn')){
           $this->reportRepo->discountingData = $this->reportRepo->getDiscountingReport();
           $result = $this->reportRepo->discountingUsageExcel();
           return $result;
        }else{
           $this->reportRepo->isPaginate = true;
           $currencyData = $this->currencyData;
           $discountingData = $this->reportRepo->getDiscountingReport();
           return view('buyer.reports.discountingUsageReportListing',compact('discountingData','currencyData','querystringArray'));
        }
        
        
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

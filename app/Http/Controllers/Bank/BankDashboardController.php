<?php

namespace App\Http\Controllers\Bank;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\PaymentInstructionInterface;

class BankDashboardController extends Controller
{
    public $PIRepo;


    public function __construct(PaymentInstructionInterface $PIRepo) {
        $this->PIRepo = $PIRepo;
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->PIRepo->bankData = loadJSON('results');
        $this->PIRepo->bankDis = true;
        $data = $this->PIRepo->bankDashboard();
        if(\Entrust::can('bank.iDiscounting.postApprove') || \Entrust::can('bank.iDiscounting.makerPostApprove'))
           $approveRejectButton = "Y";
        else
           $approveRejectButton = "N";
        //$iReqData = $this->PIRepo->getDiscountingRequest();
        foreach ($data['lastTenLoan'] as $key => $value) {
            $disDays = (strtotime($value->dueDate) - strtotime($value->discountingDate))/(60*60*24);
            $data['lastTenLoan'][$key]->bankCharge = $this->PIRepo->bankChargeCalculation($value->loanAmount,$value->manualDiscounting,$disDays);    
        } 
        //dd($data);
        return view('bank/dashboard/dashboard',compact('data','approveRejectButton'));
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

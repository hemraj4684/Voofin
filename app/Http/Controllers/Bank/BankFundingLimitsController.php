<?php

namespace App\Http\Controllers\bank;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\FundingInterface;
use URL,Input;

class BankFundingLimitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $fundingRepo;
    public function __construct(FundingInterface $fundingRepo)
    {
        $this->fundingRepo = $fundingRepo;
    }
   
    
    public function index()
    {
      $fundinglimits=$this->fundingRepo->getfundinglimitview();
      $req_pipeline=$this->fundingRepo->pipeline_request();
      //$currentExp=$this->fundingRepo->current_value();
      // dd($req_pipeline);

      return view('bank.fundingLimits.fundingLimits',compact('fundinglimits','req_pipeline'));
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
        $data = $this->fundingRepo->savefundinglimit($request);
        return redirect()->route('bank.fundingLimits.view');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

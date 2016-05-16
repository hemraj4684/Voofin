<?php

namespace App\Http\Controllers\bank;

use Illuminate\Http\Request;
use Repository\RevenueInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BankRevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $revenueRepo;
    
    public function __construct(RevenueInterface $revenueRepo)
    {
       $this->revenueRepo= $revenueRepo;
    }

    public function index()
    {
      $getrevenue=$this->revenueRepo->getrevenueshareview();
      return view('bank.revenueSharing.revenueSharing',compact('getrevenue'));  
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
    public function revenue_share_save(Request $request)
    {
       $getdata=$this->revenueRepo->save_revenue_share($request);
       return redirect()->route('bank.revenueSharing.view');
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

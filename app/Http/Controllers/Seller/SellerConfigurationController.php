<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\SellerInterface;
use App\Models\CompanyBank;
use Redirect,DB;


class SellerConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $sellerRepo;
    public function __construct(SellerInterface $sellerRepo)
    {
       $this->sellerRepo=$sellerRepo;
       $this->sellerRepo->sellerId=session('company_id');
    }


    public function index()
    {
      // $roles=$this->sellerRepo->getRoles();
      $getid = CompanyBank::where('company_id',$this->sellerRepo->sellerId)->first();
      $getdata = DB::table('companies')->select('configurations')->where('id',$this->sellerRepo->sellerId)->first();
      $json_data = json_decode($getdata->configurations,true);

      if(isset($json_data[session('typeUser')]))
        $json_data = $json_data[session('typeUser')];
    

      return view('seller.sellerConfiguration.sellerConfiguration',compact('getid','json_data'));
     
    }

    /*
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
       // dd($request);
        $message=$this->sellerRepo->sellerConfigurationsave($request);
    
        if(isset($message['success']))
        {
            return Redirect::route('seller.sellerConfiguration.view')->with('success',$message['success']);
        }
        else
        {
            return Redirect::route('seller.sellerConfiguration.view')->with('alert',$message['alert']);
        }
        //return view('seller.sellerConfiguration.sellerConfiguration',compact('message'));
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

<?php

namespace App\Http\Controllers\Bank;

use Illuminate\Http\Request;
use Auth, Input, URL, Redirect,DB;
use App\Http\Requests;
use Repository\BandInterface;
use App\Http\Controllers\Controller;

class BankBandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $bandRepo;

    public function __construct(BandInterface $bandRepo) 
    {
        $this->bandRepo = $bandRepo;
    }

    public function index()
    {
       $bands = $this->bandRepo->getBands(); 
       return view('bank.band.bandListing',compact('bands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bank.band.manageBand');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data = $this->bandRepo->save($request);
       return Redirect::route('bank.band.view');
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
        $this->bandRepo->bandId = $id; 
        $band = $this->bandRepo->getBands();
        $action = URL::route('bank.band.update', ['id' => $id]);
        return view('bank.band.manageBand',compact('band','action'));
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
        $this->bandRepo->bandId = $id;
        $data = $this->bandRepo->save($request);
        if($data['error'] == 'error')
            return Redirect::route('bank.band.add');
             
        return Redirect::route('bank.band.view');
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

    public function bandmappingview()
    {
        $data = $this->bandRepo->getbandmappingview();
        
       // DB::enableQueryLog();
        $bands = $this->bandRepo->getBands();
       // dd(dd(DB::getQueryLog()));
        return view('bank.band.bandMappingListing',compact('data','bands'));
    }
   
    public function savebandmapping(Request $request)
    {
     $bandconfig=$this->bandRepo->bandmappingsave($request);
     if($request->ajax())
        return 'success';
     else
        return Redirect::route('bank.band.bandMapping.view');
    }

    public function bandmappingdisplay(Request $request)
    { 
      $getdata=$this->bandRepo->getbandmappingdisplay($request);

       return Redirect::route('bank.band.bandMapping.view');
    }
}

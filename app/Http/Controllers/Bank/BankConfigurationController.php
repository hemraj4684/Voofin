<?php

namespace App\Http\Controllers\Bank;

use Illuminate\Http\Request;
use Repository\BankInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class BankConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $bankRepo;
    public function  __construct(BankInterface $bankRepo)
    {
        $this->bankRepo=$bankRepo;
    }
    public function index()
    {
        /*$json="";
         $file = fopen("results.json","r");
         //dd($file);
         if (trim(file_get_contents('results.json'))) {
             $string = fread($file,filesize("results.json"));
             fclose($file);
             $json=json_decode($string,true);
        }*/
        $json = loadJSON('results');
        //dd($json);
          
        return view('bank.configurations.bankConfigurations',compact('json'));

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
        $this->bankRepo->bankconfigurationsave($request);
        return redirect()->back();
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

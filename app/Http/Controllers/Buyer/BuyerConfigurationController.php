<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
use Auth,Input,URL,Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\BuyerInterface;
use Repository\BandInterface;
use App\Models\CompanyBank;
use DB;

class BuyerConfigurationController extends Controller
{    
     public $buyerRepo;
     public $bandRepo;
    
     public function __construct(BuyerInterface $buyerRepo, BandInterface $bandRepo)
     {  
     	$this->buyerRepo = $buyerRepo;
      $this->bandRepo = $bandRepo;
     	$this->buyerRepo->buyerId = session('company_id');     
      $this->bandRepo->buyerId = session('company_id');
      $this->currencyData = loadJSON('Common-Currency');
      $this->buyerRepo->loggedInUser  = session('userId');
     }

     
     public function save(Request $request)
     {
        $message = $this->buyerRepo->buyerConfiguration($request);
        
       // dd($message);
        if(isset($message['success'])) {
            //dd($message['success']);
            return Redirect::route('buyer.buyerConfiguration.view')->with('success',$message['success']);
        }
        else {
            //dd($message['alert']);
            return Redirect::route('buyer.buyerConfiguration.view')->with('alert',$message['alert']);    
        }
        return view('buyer.buyerConfiguration.buyerConfiguration',compact('message'));
     }


     public function view()
     {
      $getid = $this->buyerRepo->getCompanyBank();
      
      $roles=$this->buyerRepo->getRoles();
      $currencyData = $this->currencyData;
      $getdata=$this->buyerRepo->getBuyerConfiguration(); 
      $data=json_decode($getdata->configurations,true);

      $data = json_decode($getdata->configurations,true);
      if(isset($data[session('typeUser')]))
        $data = $data[session('typeUser')];
      

      // dd($data);

      //dd($data)
      return view('buyer.buyerConfiguration.buyerConfiguration',compact('getid','roles','data','currencyData'));
     }

     public function sellerSettingView()
     {
      $data = $this->bandRepo->getBuyerData();
      return view('buyer.buyerConfiguration.sellerSetting', compact('data'));
     }

     public function sellerSettingEdit($id)
     {
      $this->bandRepo->bandConfId = $id;
      $data = $this->bandRepo->getBuyerData();
      return view('buyer.includes.sellerSettingModal', compact('data'));
     }

     public function sellerSettingSave(Request $request)
     {

      $data = $this->bandRepo->saveBuyerData($request);
      //return redirect()->route('buyer.buyerConfiguration.sellerSetting');
      return "success";
     }
     
     
}



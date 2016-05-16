<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;

use Auth,Input,URL;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\PaymentInstructionInterface;
use Repository\SellerInterface;
use Repository\BuyerInterface;


class BuyerPiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public $piRepo;

    public function __construct(PaymentInstructionInterface $piRepo)
    {
        $this->piRepo = $piRepo;
        $this->piRepo->buyerId = session('company_id');
        $this->piRepo->roleId = session('role_id');
        $this->piRepo->userType = session('typeUser');
        $this->piRepo->companyConf = json_decode(session('company_conf'),TRUE);
        $this->piRepo->companyConf = $this->piRepo->companyConf[$this->piRepo->userType];
        $this->variousStates = loadJSON('variousStatus');
        $this->currencyData = loadJSON('Common-Currency');
        $this->piRepo->bankData = loadJSON('results');
        $this->piRepo->loggedInUser  = session('userId');
    }

   /*Show Invoice List*/
    public function index(Request $request)
    {
        $querystringArray = Input::only(['search','piStatus','piDate']);
        $this->piRepo->isPagiante=true;
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

        $piData = $this->piRepo->getData();
        $currencyData=$this->currencyData;
        $statusData = $this->variousStates;
        $statusData['status'] = $this->variousStates['PI']['Buyer'];
        $statusData['symbols'] = $this->variousStates['SYMBOLS'];
        return view('buyer.piListing.piListing',compact('piData','currencyData','statusData','querystringArray'));
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->piRepo->userId = session('userId');
        $success = $this->piRepo->store($request);
        if($this->piRepo->success){
            $request->session()->flash('message', $this->piRepo->message);
            return redirect('/buyer/piListing')->with('success',$success);
        }else{
            return redirect()->back();
        }
        
    } 
    /*Upload Pi CSV FILE*/
    public function uploadPi(Request $request)
    {
        $success = $this->piRepo->uploadPi($request);
        if($this->piRepo->success)
            return redirect('/buyer/piListing')->with('success',$success);
        else
            return redirect('/buyer/piListing');
        
    }  
    
    /*Show Invoice Modal*/

    public function showPiModal($id)
    {
        $this->piRepo->piUuid=$id;
        $currencyData = $this->currencyData;
        $piData=$this->piRepo->getPiDetails();

        $statusData['status'] = $this->variousStates['INVOICE']['Seller'];
       
        $statusData['symbols'] = $this->variousStates['SYMBOLS'];

         return view('buyer.piListing.piModal',compact('piData','currencyData','statusData'));
    }  

    public function approve(Request $request)
    {
         $this->piRepo->piUuid=$request->id;
         $result=$this->piRepo->approvePi();
         
         return redirect('/buyer/piListing');
          
    }
    public function reject(Request $request)
    {
         $result=$this->piRepo->rejectPi($request);
         
         return redirect('/buyer/piListing');
          
    }
    
   
}

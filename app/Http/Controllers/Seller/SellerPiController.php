<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;

use Auth,Input,URL;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\PaymentInstructionInterface;

class SellerPiController extends Controller
{
    
    public $piRepo;

    public function __construct(PaymentInstructionInterface $piRepo)
    {
        //$this->sellerRepo = $sellerRepo;
        //$this->buyerRepo = $buyerRepo;
        $this->piRepo = $piRepo;
        $this->piRepo->sellerId = session('company_id');
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
       // $this->piRepo->isPagiante=true;
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
           $statusArray = $this->variousStates['PI']['Seller'];
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

        $currencyData = $this->currencyData;
        $bankData = $this->piRepo->bankData;
        $bankChargeData = $this->piRepo->getBankCharge($piData);
        $statusData = $this->variousStates;
        $statusData['status'] = $this->variousStates['PI']['Seller'];
        $statusData['symbols'] = $this->variousStates['SYMBOLS'];
       
        return view('seller.piListing.piListing',compact('piData','currencyData','bankChargeData','bankData','statusData','querystringArray'));
       
    }

    /*Show Pi Modal*/

    public function showPiModal($id)
    {
        $this->piRepo->piUuid=$id;
        $currencyData = $this->currencyData;
        $piData=$this->piRepo->getPiDetails();

        $bankData = $this->piRepo->bankData;
        
        $bankCharge = $this->piRepo->bankChargeCalculation($piData->discounted_amount,$piData->manualDiscounting,$piData->discounting_days);
        
        $statusData['status'] = $this->variousStates['INVOICE']['Seller'];
       
        $statusData['symbols'] = $this->variousStates['SYMBOLS'];

        return view('seller.piListing.piModal',compact('piData','currencyData','statusData','bankCharge','bankData'));
    }  
    
    public function calculateBankCharge(Request $request)
    {
        $this->piRepo->piUuid=$request->pi_id;

        $piData=$this->piRepo->getPiDetails();

        $bankCharge = $this->piRepo->bankChargeCalculation($piData->discounted_amount,$piData->manualDiscounting,$request->diff_days);
        
        $discountRate = $this->piRepo->discountPercentage($bankCharge,$piData->discounted_amount);
        
        $balance=$piData->pi_net_amount - $piData->discounted_amount - $bankCharge;

        $jsonData='{"bankCharge":"'.number_format(round($bankCharge,2),2).'","discountRate":"'.$discountRate.'","balance":"'.number_format(round($balance,2),2).'"}';
        
        return $jsonData;//number_format($bankCharge,2);
    }

    public function paymentRequest()
    {
        $piData = $this->piRepo->getData();
        $currencyData = $this->currencyData;
        $bankData = $this->piRepo->bankData;
        $bankChargeData = $this->piRepo->getBankCharge($piData);
        return view('seller.piListing.piListing',compact('piData','currencyData','bankChargeData','bankData'));
       
    } 

   
}

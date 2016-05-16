<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use Auth,Input,URL;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\POInterface;
use Repository\InvoiceInterface;
use Repository\SellerInterface;
use Repository\BuyerInterface;
use Repository\UserInterface;
use Repository\PaymentInstructionInterface;
use DB,Response;

class APISellerController extends Controller
{

    public $sellerRepo;
    public $buyerRepo;
    public $userRepo;
    public $PORepo;
    public $PIRepo;
    public $invoiceRepo;
    public function __construct(UserInterface $userRepo, POInterface $PORepo, PaymentInstructionInterface $PIRepo,InvoiceInterface $invoiceRepo,SellerInterface $sellerRepo,BuyerInterface $buyerRepo)
    {
        $userRepo->authToken = $authToken = app('request')->header('X-Auth-Token');
        $this->sellerRepo = $sellerRepo;
        $this->buyerRepo = $buyerRepo;
        $this->userRepo = $userRepo;
        $this->PORepo = $PORepo;
        $this->PIRepo = $PIRepo;
        $this->invoiceRepo = $invoiceRepo;
        $this->invoiceRepo->isApi = true;
        $this->userData = $userRepo->getUserAuthData();
        $sellerRepo->isApi = TRUE;
        $this->sellerRepo->folder = "invoices";
        $this->sellerRepo->sellerId = $this->userData->company_id;
        $this->PIRepo->sellerId = $this->userData->company_id;
        $this->sellerRepo->roleId = $this->userData->role_id;
        $this->sellerRepo->userType = $this->userData->typeUser;
        $this->sellerRepo->companyConf = json_decode($this->userData->configurations,TRUE);
        $this->sellerRepo->companyConf = $this->sellerRepo->companyConf[$this->userData->typeUser];
        $this->variousStates = loadJSON('variousStatus');
        $this->currencyData = loadJSON('Common-Currency');
        $this->PIRepo->bankData = loadJSON('results');
        $this->sellerRepo->loggedInUser = $this->userData->loggedUserId;
        $this->buyerRepo->loggedInUser  = $this->userData->loggedUserId;
        $this->PORepo->loggedInUser     = $this->userData->loggedUserId;
        $this->PIRepo->loggedInUser     = $this->userData->loggedUserId;
        $this->invoiceRepo->loggedInUser     = $this->userData->loggedUserId;
   
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * Get Seller Invoices from Invoces Repo
     */
    public function index()
    {
        $querystringArray = Input::only(['search','invoiceStatus','invoiceDate']);
        $this->sellerRepo->filterRequest=Input::all();
        $this->invoiceRepo->sellerId = $this->userData->company_id;
        $invoices = $this->invoiceRepo->getInvoices();
        return Response::json($invoices, 200)->header('Content-Type', 'application/json');
        
    }
    
    public function getInvoicesByStatus($status){
        $this->invoiceRepo->statusArray = explode(',',$status);
        $this->invoiceRepo->sellerId = $this->userData->company_id;
        $invoices = $this->invoiceRepo->getInvoices();
        return Response::json($invoices, 200)->header('Content-Type', 'application/json');
    }

    public function sellerPOByStatus($status){
        $this->PORepo->isApi = true;
        $this->PORepo->statusArray = explode(',',$status);
        $this->PORepo->sellerId = $this->userData->company_id;
        $pos = $this->PORepo->getPos();
        return Response::json($pos, 200)->header('Content-Type', 'application/json');
    }

    public function getPOByUuid($uuid) {
        $this->PORepo->uuid = $uuid;
        $this->PORepo->sellerId = $this->userData->company_id;
        $data = $this->PORepo->getPoByAttibute();
        return Response::json($data, 200)->header('Content-Type', 'application/json');
    }
    
    public function createInvoice(Request $request){
        $this->invoiceRepo->sellerId = $this->userData->company_id;
        $success = $this->invoiceRepo->validateInvoice($request);
        return Response::json($success, 200)->header('Content-Type', 'application/json');
    }

   public function deleteInvoice($id){
        $this->invoiceRepo->uuid = $id;
        $this->invoiceRepo->deleteInvoice = true;
        $this->invoiceRepo->sellerId = $this->userData->company_id;
        $invoiceData = $this->invoiceRepo->getData();
        
        if($invoiceData->status!=5){
            $deleteData = $this->invoiceRepo->deleteInvoiceData();
            $jsonArray['error'] = 'success';
            $jsonArray['msg'] = " Invioce ".$invoiceData->invoice_number." deleted successfully.";      
        }else{
            $jsonArray['error'] = 'error';
            $jsonArray['msg'] = "Sorry you cant delete this invoice ".$invoiceData->invoice_number.", once approved!";
        }
        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');
    }
    
    public function approveInvoice($uuid){
        $this->invoiceRepo->sellerId = $this->userData->company_id;
        $this->invoiceRepo->uuid = $uuid;
        $invData = $this->invoiceRepo->approveInvoice();    
        return Response::json($invData, 200)->header('Content-Type', 'application/json');
        //return redirect()->route('seller.invoice.view');
    }

    public function rejectInvoice(Request $request){
        $this->invoiceRepo->sellerId = $this->userData->company_id;
        $this->invoiceRepo->uuid = $request->invoice_uuid;
        $invData = $this->invoiceRepo->rejectInvoice($request);

        return Response::json($invData, 200)->header('Content-Type', 'application/json');
        //return redirect()->route('seller.invoice.view');
    }
    
    public function approvePO($uuid) {
        $jsonArray['error'] = 'error';
        $jsonArray['msg'] = 'Invalid PI';
        $this->PORepo->uuid = $uuid;
        $this->PORepo->status = 3;
        $this->PORepo->sellerId = $this->userData->company_id;
        $poData = $this->PORepo->getPoByAttibute();
        
        if($poData->status == 1){
            $jsonArray['error'] = 'success';
            $jsonArray['msg'] = 'success';
            $invData = $this->PORepo->approveOrRejectPO();
        }
        
        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');
    }
    
    public function rejectPO($uuid) {
        $jsonArray['error'] = 'error';
        $jsonArray['msg'] = 'Invalid PI';
        $this->PORepo->uuid = $uuid;
        $this->PORepo->status = 4;
        $this->PORepo->sellerId = $this->userData->company_id;
        $poData = $this->PORepo->getPoByAttibute();
        if($poData->status == 1){
            $jsonArray['error'] = 'success';
            $jsonArray['msg'] = 'success';
            $invData = $this->PORepo->approveOrRejectPO();
        }
        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');
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
    public function show($uuid)
    {
        $this->invoiceRepo->uuid = $uuid;
        $invData = $this->invoiceRepo->getInvoiceByAttibute();
        return Response::json($invData, 200)->header('Content-Type', 'application/json');
    }

    public function searchBuyerByText($search) {
        $this->sellerRepo->keyword = $search;
        $this->sellerRepo->searchKey = true;
        $data = $this->sellerRepo->getBuyerAutocomplete();
        return Response::json($data, 200)->header('Content-Type', 'application/json');
    }

    public function searchBuyerPo($search,$id){
        $this->sellerRepo->keyword = $search;
        $this->sellerRepo->uuid = $id;
        $data = $this->sellerRepo->getPoData();
        return Response::json($data, 200)->header('Content-Type', 'application/json');
    }

    
    public function poItem($poUuid) {
        $this->sellerRepo->uuid = $poUuid;
        $data = $this->sellerRepo->getPoItem();
        return Response::json($data, 200)->header('Content-Type', 'application/json');
    }

    
    public function getPO() {
        $this->buyerRepo->isApi = TRUE;
        $this->buyerRepo->po = true; //this is for accessing po related functions from BuyerRepo
        $this->buyerRepo->viewStatus = array(1,3,4,5);
        $poList = $this->buyerRepo->getData();
        return Response::json($poList, 200)->header('Content-Type', 'application/json');
    }

    
    
    //Payment Instructions
    
    public function getPi(){
        $this->PIRepo->sellerId = $this->userData->company_id;
//        /dd($this->userData->configurations);
        $this->PIRepo->bankData = loadJSON('results');
        $this->PIRepo->companyConf = $conf = json_decode($this->userData->configurations,TRUE);
        $this->PIRepo->companyConf[$this->userData->typeUser];
        $piData = $this->PIRepo->getData();
        return Response::json($piData, 200)->header('Content-Type', 'application/json');
    }

    public function getPiDetail($uuid) {
        $this->PIRepo->bankData = loadJSON('results');
        $this->PIRepo->sellerId = $this->userData->company_id;
        $this->PIRepo->piUuid=$uuid;
        $piData=$this->PIRepo->getPiDetails();
        return Response::json($piData, 200)->header('Content-Type', 'application/json');
    }
    
    
    public function iDiscounting($date,$type) {
        $this->PIRepo->sellerId = $this->userData->company_id;
        $this->PIRepo->sellerIDis = true;
        $todayDate = date('Y-m-d');
        if($date){
            $this->PIRepo->cashDate = $date;//if date is enter
            $this->PIRepo->cashDate = date("Y-m-d",strtotime($this->PIRepo->cashDate));//for database date style
            if($type == 'tab2'){
               if($this->PIRepo->cashDate > $todayDate) {
                    $this->PIRepo->dataDateWise = TRUE;
               }
               else{
                    $jsonArray = array();
                    return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');             
               }
            }
        }
        $iDisData = $this->PIRepo->getData();//this data is between min and max payment days 
        if($iDisData){
            foreach($iDisData as $key => $val){
                $iDisData[$key]->bankCharge = $this->PIRepo->getBankCharge($val);
            }
        }
        
        return Response::json($iDisData, 200)->header('Content-Type', 'application/json');
    }
    
    
    public function storeDiscounting(Request $request){
        $this->PIRepo->bankData = loadJSON('results');
        $this->PIRepo->companyConf = $conf = json_decode($this->userData->configurations,TRUE);
        //dd($conf);
        $this->PIRepo->companyConf = $this->PIRepo->companyConf[$this->userData->typeUser];
        $message = $this->PIRepo->postRequestPayment($request);

        $jsonArray['error'] = $message;
        $jsonArray['msg']   = $message;
        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');
    }

    public function requestPayment(Request $request) {
        $finalData = $this->PIRepo->getrequestPayment(Input::get('piId'));
        $finalData['invoiceAmt'] = Input::get('invoiceAmt');
        $finalData['piAmt'] = Input::get('piAmt');
        $finalData['piId'] = Input::get('piId');
        $finalData['dueDate'] = Input::get('dueDate');
        $finalData['invNumber'] = Input::get('invNumber');
        $finalData['eligibleAmt'] = Input::get('eligibleAmt');

        if(Input::has('selectedDate') && Input::has('maxDueDate')){
            $finalData['balanceAmt'] = $finalData['piAmt'] - $finalData['eligibleAmt'] - $finalData['bankChargeSum'];
            
        }
        return Response::json($finalData, 200)->header('Content-Type', 'application/json');
    }
    
    public function getSellerBuyerList(){
        $data = $this->sellerRepo->getBuyerAutocomplete();
        return Response::json($data, 200)->header('Content-Type', 'application/json');
    }

    public function getDiscountingRequest(Request $request) 
    {
        if($request->invoiceStatus){
            $finalStatus = $temp = array();
            $temp = array_keys($this->variousStates['DISCOUNTING']['Seller'], $request->invoiceStatus);
            foreach ($temp as $key => $value) {
                array_push($this->PIRepo->finalStatus, $value);    
            }
        }

        $iReqData = $this->PIRepo->getDiscountingRequest();

        foreach ($iReqData as $key => $value) {
            $iReqData[$key]->discoutingDays = (strtotime($value->dueDate)- strtotime($value->discountingDate))/(60*60*24);
            $iReqData[$key]->bankCharge = $this->PIRepo->bankChargeCalculation($value->loanAmount,$value->manualDiscounting,$iReqData[$key]->discoutingDays);
        }
        
        return Response::json($iReqData, 200)->header('Content-Type', 'application/json');
    }

    public function postApprove(Request $request)
    {
        $jsonArray['error'] = 'error';
        $jsonArray['msg']   = 'Invalid Request';
        $this->PIRepo->statusId = $request->statusId;

        if($request->remarks)
           $this->PIRepo->remarks = $request->remarks; 

        if(is_array($request->discountingId)){
            foreach ($request->discountingId as $key => $value) {
               $this->PIRepo->discountingId =  $value;
               $message = $this->PIRepo->changeStatus();
            }
        } else{
            $this->PIRepo->discountingId =  $request->discountingId;
            $message = $this->PIRepo->changeStatus();
        }
        $jsonArray['error'] = $message;
        $jsonArray['msg']   = $message;

        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');
        
    }
    
    public function getDashboardData()
    {
        $jsonArray['error'] = 'error';
        $jsonArray['sumDiscountedAmount']   = 'Invalid Request';
        $this->PIRepo->sellerIDis     = true;
        $this->PIRepo->dashboardData  = true;
        $iDisData = $this->PIRepo->getData();
        if($iDisData[0]){
            $jsonArray['error'] = 'success';
            $jsonArray['sumDiscountedAmount'] = $iDisData[0];
        }    
        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');
        
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

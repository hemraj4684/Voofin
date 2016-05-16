<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use Auth,Input,URL;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\SellerInterface;
use Repository\BuyerInterface;
use Repository\UserInterface;
use Repository\POInterface;
use Repository\InvoiceInterface;
use Repository\PaymentInstructionInterface;
use DB,Response;

class APIBuyerController extends Controller
{
    public $sellerRepo;
    public $buyerRepo;
    public $userRepo;
    public $PORepo;
    public $PIRepo;
    //public $invoiceRepo;
    
    public function __construct(UserInterface $userRepo,SellerInterface $sellerRepo,BuyerInterface $buyerRepo,POInterface $PORepo,InvoiceInterface $invoiceRepo,PaymentInstructionInterface $PIRepo)
    {

        $userRepo->authToken = $authToken = app('request')->header('X-Auth-Token');
        $this->sellerRepo             = $sellerRepo;
        $this->invoiceRepo            = $invoiceRepo;
        $this->PORepo                 = $PORepo;
        $this->PIRepo                 = $PIRepo;
        $this->buyerRepo              = $buyerRepo;
        $this->userRepo               = $userRepo;
        $this->userData               = $userRepo->getUserAuthData();
        $this->buyerRepo->isApi       = TRUE;
        $this->buyerRepo->folder      = "purchase_order";
        $this->buyerRepo->buyerId     = $this->userData->company_id;
        $this->buyerRepo->roleId      = $this->userData->role_id;
        $this->buyerRepo->userType    = $this->userData->typeUser;
        $this->sellerRepo->userType   = $this->userData->typeUser;
        $this->buyerRepo->compConf    = json_decode($this->userData->configurations,TRUE);
        $this->buyerRepo->compConf    = $this->buyerRepo->compConf[$this->userData->typeUser];
        $this->sellerRepo->companyConf= json_decode($this->userData->configurations,TRUE);
        $this->sellerRepo->companyConf= $this->sellerRepo->companyConf[$this->userData->typeUser];
        $this->variousStates          = loadJSON('variousStatus');
        $this->currencyData           = loadJSON('Common-Currency');
        $this->sellerRepo->loggedInUser = $this->userData->loggedUserId;
        $this->buyerRepo->loggedInUser  = $this->userData->loggedUserId;
        $this->PORepo->loggedInUser     = $this->userData->loggedUserId;
        $this->PIRepo->loggedInUser     = $this->userData->loggedUserId;
        $this->invoiceRepo->loggedInUser= $this->userData->loggedUserId;
    }
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->PORepo->po = true; //this is for accessing po related functions from BuyerRepo
        $poList = $this->PORepo->getData();
        return Response::json($poList, 200)->header('Content-Type', 'application/json');
    }

    public function buyerPOByStatus($status){
        $this->PORepo->isApi = true;
        $this->PORepo->statusArray = explode(',',$status);
        $this->PORepo->buyerId = $this->userData->company_id;
        $pos = $this->PORepo->getPos();
        return Response::json($pos, 200)->header('Content-Type', 'application/json');
    }

    public function getPOByUuid($uuid) {
        $this->PORepo->uuid = $uuid;
        $this->PORepo->buyerId = $this->userData->company_id;
        $data = $this->PORepo->getPoByAttibute();
        return Response::json($data, 200)->header('Content-Type', 'application/json');
    }

    public function getInvoicesByStatus($status){
        $this->invoiceRepo->isApi = true;
        $this->invoiceRepo->statusArray = explode(',',$status);
        $this->invoiceRepo->buyerId = $this->userData->company_id;
        $invoices = $this->invoiceRepo->getInvoices();
        return Response::json($invoices, 200)->header('Content-Type', 'application/json');
    }
    public function getInvoiceByUuid($uuid){
        $this->invoiceRepo->uuid = $uuid;
        $this->invoiceRepo->buyerId = $this->userData->company_id;
        $invoices = $this->invoiceRepo->getInvoices();
        return Response::json($invoices, 200)->header('Content-Type', 'application/json');
    }

    public function getPi(){
        $this->PIRepo->buyerId = $this->userData->company_id;
        $this->PIRepo->bankData = loadJSON('results');
        $this->PIRepo->compConf = $conf = json_decode($this->userData->configurations,TRUE);
        $this->PIRepo->compConf[$this->userData->typeUser];
        $piData = $this->PIRepo->getData();
        return Response::json($piData, 200)->header('Content-Type', 'application/json');
    }

    public function getPiDetail($uuid) {
        $this->PIRepo->bankData = loadJSON('results');
        $this->PIRepo->piUuid=$uuid;
        $this->PIRepo->buyerId = $this->userData->company_id;
        $piData=$this->PIRepo->getPiDetails();
        return Response::json($piData, 200)->header('Content-Type', 'application/json');
    }
 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function associateSeller()
    {
       // dd($request);
        $this->buyerRepo->keyword = "";
        $data = $this->buyerRepo->getData();
        return Response::json($data, 200)->header('Content-Type', 'application/json');
    }

    public function poPresentYN(Request $request){
        $yn = $this->buyerRepo->poPresentYN($request->purOrderNumber);
         if($yn !== null)
            return Response::json(['success' => 'PO Number already exist! Please use another Number'],200)->header('Content-Type', 'application/json');
         else
            return Response::json(['success' => 'PO Number not exist'],200)->header('Content-Type', 'application/json');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jsonArray = $this->buyerRepo->store($request);
        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');
    }

    public function approve(Request $request)
    {   
        $jsonArray['error']  = 'error';
        $jsonArray['msg']    = 'Invalid Data';
        
        //dd($request->uuid);
        $this->buyerRepo->uuid   = $request->uuid;
        $this->buyerRepo->status = "1";
        
        //if(\Entrust::can('buyer.po.approve')){
        $cs = $this->buyerRepo->changePOstatus();
        //}

        if(isset($cs) && $cs) {
           $jsonArray['error'] = 'success';
           $jsonArray['msg']   = 'success';
        }

        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');

    }
    /*this block is for PO approval ends here*/


    /*this block is for PO rejection starts here*/
    public function reject(Request $request)
    {
        $jsonArray['error']  = 'error';
        $jsonArray['msg']    = 'Invalid Data';

        $this->buyerRepo->uuid   = $request->uuid;
        $this->buyerRepo->status = "2";
        
        //if(\Entrust::can('buyer.po.reject')){
          $cs = $this->buyerRepo->changePOstatus();
        //}

        if(isset($cs) && $cs) {
           $jsonArray['error'] = 'success';
           $jsonArray['msg']   = 'success';
        }
        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');
    }

    public function destroy(Request $request)
    {
        //$this->buyerRepo->deletePo = true;
        $jsonArray['error']  = 'error';
        $jsonArray['msg']    = 'Invalid Data';
        $this->buyerRepo->uuid = $request->uuid;
        $cs = $this->buyerRepo->changeStatus();
        if(isset($cs) && $cs) {
           $jsonArray['error'] = 'success';
           $jsonArray['msg']   = 'success';
        }
        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');
    }
    /*Approve Invoice*/
    public function approveInvoice(Request $request)
    {
        $jsonArray['error']  = 'error';
        $jsonArray['msg']    = 'Invalid Data';
        $this->sellerRepo->uuid = $request->invoice_uuid;
        $cs = $this->sellerRepo->approveInvoice();
        if(isset($cs) && $cs) {
           $jsonArray['error'] = 'success';
           $jsonArray['msg']   = 'success';
        }
        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');
    }

    /*Reject Invoice*/
    public function rejectInvoice(Request $request)
    {
        $jsonArray['error']  = 'error';
        $jsonArray['msg']    = 'Invalid Data';
        $cs = $this->sellerRepo->rejectInvoice($request);
        if(isset($cs) && $cs) {
           $jsonArray['error'] = 'success';
           $jsonArray['msg']   = 'success';
        }
        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');
    }

    public function approvePI(Request $request)
    {
        $this->PIRepo->piUuid = $request->pi_id;
        $cs = $this->PIRepo->approvePi();
         
        if(isset($cs) && $cs) {
           $jsonArray['error'] = 'success';
           $jsonArray['msg']   = 'success';
        }
        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');
          
    }

    /*Reject PI from buyer*/
    public function rejectPI(Request $request)
    {
        $jsonArray['error']  = 'error';
        $jsonArray['msg']    = 'Invalid Data';
        $cs = $this->PIRepo->rejectPi($request);
        if(isset($cs) && $cs) {
           $jsonArray['error'] = 'success';
           $jsonArray['msg']   = 'success';
        }
        return Response::json($jsonArray, 200)->header('Content-Type', 'application/json');
    }

    public function showDashData()
    {
        $this->buyerRepo->viewStatus['openPO'] = array('table' =>'purchase_orders', 'column'=>'final_amount', 'status'=>array(0,1,3));
        $this->buyerRepo->viewStatus['openInv'] = array('table' =>'invoices', 'column'=>'final_amount', 'status'=>array(1,3,5,7));
        $this->buyerRepo->viewStatus['AppPI'] = array('table' =>'payment_instructions', 'column'=>'net_pi_amount', 'status'=>array(1,3));
        $result = $this->buyerRepo->dashboardData();
        return Response::json($result, 200)->header('Content-Type', 'application/json');
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
    
}

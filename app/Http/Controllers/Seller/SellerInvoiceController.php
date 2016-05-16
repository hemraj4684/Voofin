<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;

use Auth,Input,URL,Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\SellerInterface;
use Repository\BuyerInterface;
use Repository\InvoiceInterface;

class SellerInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public $sellerRepo;
    public $buyerRepo;
    public $invoiceRepo;


    public function __construct(SellerInterface $sellerRepo,InvoiceInterface $invoiceRepo,BuyerInterface $buyerRepo)
    {
        $this->sellerRepo = $sellerRepo;
        $this->buyerRepo = $buyerRepo;
        $this->invoiceRepo = $invoiceRepo;
        $this->sellerRepo->folder = "invoices";
        $this->sellerRepo->sellerId = session('company_id');
        $this->sellerRepo->roleId = session('role_id');
        $this->sellerRepo->userType = session('typeUser');
        $this->sellerRepo->companyConf = json_decode(session('company_conf'),TRUE);
        $this->sellerRepo->companyConf = $this->sellerRepo->companyConf[$this->sellerRepo->userType];
        $this->invoiceRepo->sellerId = session('company_id');
        $this->invoiceRepo->roleId = session('role_id');
        $this->invoiceRepo->userType = session('typeUser');
        $this->invoiceRepo->folder = "invoices";
        $this->invoiceRepo->companyConf = json_decode(session('company_conf'),TRUE);
        $this->invoiceRepo->companyConf = $this->invoiceRepo->companyConf[$this->invoiceRepo->userType];
        $this->variousStates = loadJSON('variousStatus');
        $this->currencyData = loadJSON('Common-Currency');
        $this->invoiceRepo->loggedInUser  = session('userId');
    }

    public function index(Request $request)
    {   
        $this->invoiceRepo->userId = session('userId');
        $querystringArray = Input::only(['search','invoiceStatus','invoiceDate']);

        if($request->input('invoiceDate')){
          $date = explode("-",$request->input('invoiceDate'));
          if(count($date)>1){
              $this->invoiceRepo->startDate = $date[0];
              $this->invoiceRepo->endDate = $date[1]; 
          } 
        }
        if($request->input('invoiceStatus')){
           $searchArray = array();
           $inputArray = $request->input('invoiceStatus');
           $statusArray = $this->variousStates['INVOICE']['Seller'];
           foreach($statusArray as $key => $value){
             if(in_array($value,$inputArray)){
                array_push($searchArray,$key);
            }
           }
           $this->invoiceRepo->statusArray = $searchArray;  
          
        }
        if($request->input('search')){
           $this->invoiceRepo->keywords = $request->input('search');
        }
        
        $invoiceData = $this->invoiceRepo->getInvoices();
        
        
        $pieChartData = $this->invoiceRepo->getStausPieChart();

        $this->invoiceRepo->statusArray = [7,8];
        $receivedAmount = $this->invoiceRepo->summaryDashboard();

        $this->invoiceRepo->statusArray = [1,3,5];
        $outstandingAmount = $this->invoiceRepo->summaryDashboard();

        $currencyData = $this->currencyData;
         
        $statusData['status'] = $this->variousStates['INVOICE']['Seller'];
       
        $statusData['symbols'] = $this->variousStates['SYMBOLS'];
        
        return view('seller.invoice.invoiceListing',compact('invoiceData','querystringArray','currencyData','statusData','pieChartData','receivedAmount','outstandingAmount'));
    }

    public function autocompleteBuyer()
    {
        $this->sellerRepo->keyword = Input::get('term');
        $data = $this->sellerRepo->getBuyerAutocomplete();
        return $data;
    }
    public function showBuyer()
    {
        $this->sellerRepo->companyType="Buyer";
        $this->sellerRepo->keyword = Input::get('term');
        $data = $this->sellerRepo->getAllBuyer();
        return $data;
    }
    public function autocompletePo()
    {

        $this->sellerRepo->keyword = Input::get('term');
        $this->sellerRepo->uuid = Input::get('id');
        $data = $this->sellerRepo->getPoData();
        return json_encode($data);
    }
    public function poItem()
    {
        $this->sellerRepo->uuid = Input::get('po_uuid');
        $data = $this->sellerRepo->getPoItem();
        return json_encode($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
       $taxData=$this->sellerRepo->getTax(); 
       $currencyData = $this->currencyData;
       return view('seller.invoice.invoiceManage',compact('taxData','currencyData'));
    }
    

    public function flipToInvoice($id)
    {
     
        $this->sellerRepo->flipInvoice = true;

        $taxData=$this->sellerRepo->getTax(); 
        $this->buyerRepo->uuid = $id;
        $poData = $this->buyerRepo->getData();
        
        $this->buyerRepo->sellerId = $poData->buyer_id;
        $buyerData = $this->buyerRepo->getDataCompany();

        $this->buyerRepo->poId = $poData->id;
        $poItemData = $this->buyerRepo->getPOItem();

       
       return view('seller.invoice.invoiceFlip',compact('poData','taxData','buyerData','poItemData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->invoiceRepo->userId = session('userId');
        $this->invoiceRepo->sellerId = session('company_id');
        $data = $this->invoiceRepo->validateInvoice($request);
        return Response::json($data,200);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //$this->sellerRepo->uuid = $id;
        $this->invoiceRepo->uuid = $id;
       // $invData = $this->sellerRepo->getInvoiceDetails();
        $invData = $this->invoiceRepo->getData();
        $currencyData = $this->currencyData;
        $statusData['status'] = $this->variousStates['INVOICE']['Seller'];
       
        $statusData['symbols'] = $this->variousStates['SYMBOLS'];
        return view('seller.invoice.invoiceModal',compact('invData','currencyData','statusData'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPoModal($id)
    {

        $this->buyerRepo->uuid = $id;
        $poData = $this->buyerRepo->getData();
        
        $this->buyerRepo->sellerId = $poData->buyer_id;
        $buyerData = $this->buyerRepo->getDataCompany();

        $this->buyerRepo->sellerId = $poData->seller_id;
        $sellerData = $this->buyerRepo->getDataCompany();

        $this->buyerRepo->poId = $poData->id;
        $poItemData = $this->buyerRepo->getPOItem();
        return view('buyer.includes.poModal', compact('poData','buyerData','sellerData','poItemData'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->invoiceRepo->uuid = $id;
        $this->invoiceRepo->userId = session('userId');
        $invData = $this->invoiceRepo->getData();
        $taxData=$this->sellerRepo->getTax();
        $currencyData = $this->currencyData;
        if($invData->status!=5 && $invData->status!=7 && $invData->status!=8){
            return view('seller.invoice.invoiceManage',compact('invData','taxData','currencyData'));
        }else{
            $nonEditMsg = "Sorry you cant edit this invoice ".$invData->invoice_number.", once approved or paid!";
           return redirect('/seller/invoice')->with('nonEditMsg', $nonEditMsg);
            
        }
        
    }

    /**
     * Delete the invoice attachment the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAttachment($id)
    {
        $this->invoiceRepo->uuid = $id;
        $this->invoiceRepo->deleteAttachment = true;
        $result = $this->invoiceRepo->deleteInvoiceData();
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->invoiceRepo->uuid = $id;
        $this->invoiceRepo->deleteInvoice = true;
        $invoiceData = $this->invoiceRepo->getData();
        if($invoiceData->status!=5){
            $deleteData = $this->invoiceRepo->deleteInvoiceData();
            $deleteMsg = " Invoce ".$invoiceData->invoice_number." deleted successfully.";
            return redirect('/seller/invoice')->with('deleteMsg', $deleteMsg);
        }else{
            $nonEditMsg = "Sorry you cant delete this invoice ".$invoiceData->invoice_number.", once approved!";
           return redirect('/seller/invoice')->with('nonEditMsg', $nonEditMsg);
            
        }
         
    }
    public function upload(Request $request)
    {
        $invData = $this->invoiceRepo->uploadAttachment($request);
        return redirect('/seller/invoice');
    }
    public function approve($id)
    {
        $this->invoiceRepo->uuid = $id;
        $result = $this->invoiceRepo->approveInvoice();

        return redirect('/seller/invoice');
        
    }
    public function reject(Request $request)
    {
        $this->invoiceRepo->uuid = $request->invoice_uuid;
        $invData = $this->invoiceRepo->rejectInvoice($request);
         
         return redirect('/seller/invoice');
    }

    public function checkInvoiceNumber(Request $request)
    {
        $result = $this->invoiceRepo->validateInvoiceNumber($request);

        return $result;
    }

}

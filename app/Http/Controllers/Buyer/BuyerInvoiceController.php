<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;

use Auth,Input,URL,Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\SellerInterface;
use Repository\BuyerInterface;
use Repository\InvoiceInterface;

class BuyerInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public $sellerRepo;
    public $buyerRepo;
    public $invoiceRepo;

    public function __construct(SellerInterface $sellerRepo,BuyerInterface $buyerRepo,InvoiceInterface $invoiceRepo)
    {
        $this->sellerRepo = $sellerRepo;
        $this->buyerRepo = $buyerRepo;
        $this->invoiceRepo = $invoiceRepo;
        $this->sellerRepo->folder = "invoices";
        $this->sellerRepo->buyerId = session('company_id');
        $this->sellerRepo->roleId = session('role_id');
        $this->sellerRepo->userType = session('typeUser');
        $this->sellerRepo->companyConf = json_decode(session('company_conf'),TRUE);
        $this->sellerRepo->companyConf = $this->sellerRepo->companyConf[$this->sellerRepo->userType];
        $this->invoiceRepo->buyerId = session('company_id');
        $this->invoiceRepo->roleId = session('role_id');
        $this->invoiceRepo->userType = session('typeUser');
        $this->invoiceRepo->companyConf = json_decode(session('company_conf'),TRUE);
        $this->invoiceRepo->companyConf = $this->invoiceRepo->companyConf[$this->invoiceRepo->userType];
        $this->variousStates = loadJSON('variousStatus');
        $this->currencyData = loadJSON('Common-Currency');
        $this->invoiceRepo->loggedInUser  = session('userId');
    }   

   /*Show Invoice List*/
    public function index(Request $request)
    {
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
           $statusArray = $this->variousStates['INVOICE']['Buyer'];
           foreach($statusArray as $key => $value){
            
            if(in_array($value,$inputArray)){
                array_push($searchArray,$key);
            }
           }
           $this->invoiceRepo->statusArray = $searchArray;  
          
       }else{
         $this->invoiceRepo->statusArray = [1, 3, 4, 5, 6, 7, 8];
        }
       
        $this->invoiceRepo->keywords = $request->input('search');
        $invoiceData = $this->invoiceRepo->getInvoices();
        $currencyData = $this->currencyData;
        
        $this->invoiceRepo->statusArray = [1, 3, 4, 5, 6, 7, 8];
        $pieChartData = $this->invoiceRepo->getStausPieChart();

        $this->invoiceRepo->statusArray = [7,8];
        $receivedAmount = $this->invoiceRepo->summaryDashboard();

        $this->invoiceRepo->statusArray = [1,3,5];
        $outstandingAmount = $this->invoiceRepo->summaryDashboard();
        $statusData['status'] = $this->variousStates['INVOICE']['Buyer'];
        $statusData['symbols'] = $this->variousStates['SYMBOLS'];
        return view('buyer.invoice.invoiceListing',compact('invoiceData','querystringArray','currencyData','statusData','pieChartData','receivedAmount','outstandingAmount'));
    }

    /*Show PO Modal*/
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

    /*Show Invoice Modal*/
    public function showInvoiceModal($id)
    {
        //$this->sellerRepo->uuid = $id;
        //$invData = $this->sellerRepo->getData();
        $this->invoiceRepo->uuid = $id;
        $invData = $this->invoiceRepo->getData();
        $currencyData = $this->currencyData;
        $configData = $this->invoiceRepo->companyConf;
        $statusData['status'] = $this->variousStates['INVOICE']['Buyer'];
        $statusData['symbols'] = $this->variousStates['SYMBOLS'];
        
        return view('buyer.invoice.invoiceModal',compact('invData','currencyData','statusData','configData'));
    }

    /*Upload Attachment*/
    public function upload(Request $request)
    {
        $invData = $this->sellerRepo->uploadAttachment($request);
        return redirect()->route('buyer.invoice.view');
    }

    /*Approve Invoice*/
    public function approve($id)
    {
        $this->invoiceRepo->uuid = $id;
        $invData = $this->invoiceRepo->approveInvoice();
        Session::flash('message', $invData['msg']);
        return redirect()->route('buyer.invoice.view');
    }

    /*Reject Invoice*/
    public function reject(Request $request)
    {
        $this->invoiceRepo->userId = session('userId');
        $invData = $this->invoiceRepo->rejectInvoice($request);
        Session::flash('message', $invData['msg']);
        return redirect()->route('buyer.invoice.view');
    }

    public function showSeller()
    {
        $this->sellerRepo->companyType="Seller";
        $this->sellerRepo->keyword = Input::get('term');
        $data = $this->sellerRepo->getAllBuyer();
        return $data;
    }

}
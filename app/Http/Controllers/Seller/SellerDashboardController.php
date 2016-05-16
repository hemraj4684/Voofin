<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\PaymentInstructionInterface;
use Repository\SellerInterface;
use Repository\InvoiceInterface;
//use App\Helpers\Helpers as Helper;
class SellerDashboardController extends Controller
{
    public $sellerRepo;
    public $invoiceRepo;
    public $piRepo;

    public function __construct(InvoiceInterface $invoiceRepo,PaymentInstructionInterface $piRepo,SellerInterface $sellerRepo)
    {
        $this->sellerRepo = $sellerRepo;
        $this->piRepo = $piRepo;
        $this->invoiceRepo = $invoiceRepo;
        $this->piRepo->sellerId = $this->sellerRepo->sellerId = session('company_id');
        $this->piRepo->roleId = $this->sellerRepo->roleId = session('role_id');
        $this->piRepo->userType = $this->sellerRepo->userType = session('typeUser');
        $this->piRepo->companyConf = $this->sellerRepo->companyConf = json_decode(session('company_conf'),TRUE);
        $this->piRepo->companyConf = $this->piRepo->companyConf[$this->piRepo->userType];
        $this->sellerRepo->companyConf = $this->sellerRepo->companyConf[$this->sellerRepo->userType];
        $this->variousStates = loadJSON('variousStatus');
        $this->currencyData = loadJSON('Common-Currency');
        $this->piRepo->bankData = loadJSON('results');
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->piRepo->sellerIDis = true;
        $iDisData = $this->piRepo->getData();
        $iDisBankChargeData = $this->piRepo->getBankCharge($iDisData);
        $currencyData = $this->currencyData;

        $this->invoiceRepo->invoiceLimit = 5;
        $invoiceData = $this->invoiceRepo->getData();

        $this->invoiceRepo->statusArray = [1, 3, 5, 7];
        $openInvoiceSum = $this->invoiceRepo->summaryDashboard();

        $this->invoiceRepo->statusArray = [5];
        $approvedInvoiceSum = $this->invoiceRepo->summaryDashboard();

        $this->piRepo->dashboardData  = true;
        $iDisD = $this->piRepo->getData();
        //dd($iDisD,$this->piRepo->dashboardData);
        $availableCash = $iDisD[0];
        
        $statusData = $this->variousStates;
        $statusData['status'] = $this->variousStates['INVOICE']['Seller'];
        $statusData['symbols'] = $this->variousStates['SYMBOLS'];

        $this->sellerRepo->toId = session('userId');
        $this->sellerRepo->objectType = 'invoice';
        $invoiceNotification = $this->sellerRepo->getNotifications();
        $this->sellerRepo->objectType = 'po';
        $poNotification = $this->sellerRepo->getNotifications();

        return view('seller.dashboard.dashboard',compact('iDisBankChargeData','iDisData','currencyData','invoiceData','statusData','piData','openInvoiceSum','approvedInvoiceSum','availableCash','invoiceNotification','poNotification'));
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

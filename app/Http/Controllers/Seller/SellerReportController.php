<?php
namespace App\Http\Controllers\Seller;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\ReportInterface;
use Repository\PaymentInstructionInterface;

class SellerReportController extends Controller
{
    public $piRepo;
    public $reportRepo;

    public function __construct(ReportInterface $reportRepo,PaymentInstructionInterface $piRepo)
    {
        $this->reportRepo = $reportRepo;
        $this->piRepo = $piRepo;
        $this->reportRepo->sellerId = session('company_id');
        $this->reportRepo->roleId = session('role_id');        
        $this->reportRepo->companyConf = json_decode(session('company_conf'),TRUE);
        $this->reportRepo->companyConf = $this->reportRepo->companyConf[session('typeUser')];
        $this->variousStates = loadJSON('variousStatus');
        $this->currencyData = loadJSON('Common-Currency');
        $this->reportRepo->bankData = loadJSON('results');

    }

    public function discountingUsageReport(Request $request)
    {
        $this->reportRepo->isDiscounting = true;
        $querystringArray = Input::only(['search']);
        $this->reportRepo->piStatusArray = [1, 3, 4];
        $this->reportRepo->discountingStatusArray = [5, 7, 8];
        $this->reportRepo->keywords = $request->input('search');
        
        if(Input::has('excelBtn')){
           $this->reportRepo->discountingData = $this->reportRepo->getDiscountingReport();
           $result = $this->reportRepo->discountingUsageExcel();
           return $result;
        }else{
           $this->reportRepo->isPaginate = true;
           $currencyData = $this->currencyData;
           $discountingData = $this->reportRepo->getDiscountingReport();
           return view('seller.reports.sellerDiscountingUsageReportListing',compact('discountingData','currencyData','querystringArray'));
        }
        
        
    }
    /*public function downloadDiscountingUsageCSV()
    {
        $this->reportRepo->piStatusArray = [1, 3, 4];
        $this->reportRepo->discountingStatusArray = [5, 7, 8];
        $this->reportRepo->isCSV = true;
        $this->reportRepo->discountingData = $this->reportRepo->getDiscountingUsageReport();
        $result = $this->reportRepo->discountingUsageCSV();
        return $result;
    }*/
    public function potentialDiscountingReport(Request $request)
    {
        $this->reportRepo->sellerIDis = true;
        
        $this->reportRepo->bankData = loadJSON('results');
        $querystringArray = Input::only(['search']);
        $this->reportRepo->keywords = $request->input('search');
        $currencyData = $this->currencyData;
        
        if(Input::has('excelBtn')){
           $this->reportRepo->discountingData = $this->reportRepo->getDiscountingReport();
           $result = $this->reportRepo->potentialDiscountingExcel();
           return $result;
        }else{
           $this->reportRepo->isPaginate = true;
           $currencyData = $this->currencyData;
           $discountingData = $this->reportRepo->getDiscountingReport();
           return view('seller.reports.potentialDiscountingReportListing',compact('discountingData','currencyData','querystringArray'));
        }
        
    }
    

}

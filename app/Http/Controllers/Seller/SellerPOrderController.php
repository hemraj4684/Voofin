<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Http\Request;
use Auth,Input,URL;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\BuyerInterface;
use Repository\RoleInterface;

class SellerPOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public $buyerRepo;
    public $roleRepo;

    public function __construct(BuyerInterface $buyerRepo, RoleInterface $roleRepo)
    {
        $this->buyerRepo = $buyerRepo;
        $this->roleRepo = $roleRepo;
        $this->buyerRepo->sellerId = session('company_id');
        $this->buyerRepo->compConf = json_decode(session('company_conf'),TRUE);
        $this->buyerRepo->folder = "purchase_order";
        $this->buyerRepo->variousStates = loadJSON('variousStatus'); 
        $this->currencyData = loadJSON('Common-Currency');
        $this->buyerRepo->loggedInUser  = session('userId');
    }

    public function index()
    {
        $this->buyerRepo->po = true; //this is for accessing po related functions from BuyerRepo
        $this->buyerRepo->viewStatus = array(1,3,4,5);
        $poList = $this->buyerRepo->getData();
        $sellerList = $this->buyerRepo->getDataCompany();
        $this->buyerRepo->variousStates = loadJSON('variousStatus');
        $statusData['status'] = $this->buyerRepo->variousStates['PO']['Seller'];
        $statusData['symbols'] = $this->buyerRepo->variousStates['SYMBOLS']; 
        $this->currencyData = loadJSON('Common-Currency');
       // $amountInvoiced = $this->buyerRepo->getAmountInvoiced($poList);
        $currencyData = $this->currencyData;
        return view('seller.poListing.poListing', compact('poList','sellerList','currencyData','statusData'));
    }

    public function autocomplete()
    {
        $this->buyerRepo->keyword = Input::get('term');
        $data = $this->buyerRepo->getData();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('buyer.po.poManage');
    }

    
    public function view()
    {
        return view('buyer.po.poModal');   
    }

    public function show($id)
    {
        //dd($id,\Entrust::can('seller.po.approve'));
          

        $this->buyerRepo->uuid = $id;
        $poData = $this->buyerRepo->getData();
        
        $this->buyerRepo->sellerId = $poData->buyer_id;
        $buyerData = $this->buyerRepo->getDataCompany();

        $this->buyerRepo->sellerId = $poData->seller_id;
        $sellerData = $this->buyerRepo->getDataCompany();
        
        $this->buyerRepo->poId = $poData->id;
        $poItemData = $this->buyerRepo->getPOItem();
        $poAttachData = $this->buyerRepo->getPOAttachment();

        $statusData['status'] = $this->buyerRepo->variousStates['PO']['Buyer'];
        $statusData['symbols'] = $this->buyerRepo->variousStates['SYMBOLS'];
        $cur = $poData->currency;
              if(!empty($cur))
                $symbol = $this->currencyData[$cur]['symbol_native'];
              else
                $symbol = '';
        return view('seller.includes.poModal', compact('poData','buyerData','sellerData','poItemData','poAttachData','statusData','symbol'));
    }

    /*this block is for PO approval strats here*/
    public function approve($id)
    {   
        $this->roleRepo->permissionName = 'seller.po.approve';
        $this->buyerRepo->uuid = $id;
        $this->buyerRepo->status = "3";
        $permissionId = $this->roleRepo->p_getData();
        $roleId = session('role_id');

        if($permissionId && $roleId)
            $roleHasPermission = $this->roleRepo->checkRolePermission($permissionId->id, $roleId);
        else
            $roleHasPermission = false;

        if($roleHasPermission){
           $this->buyerRepo->changePOstatus();
        }

        return redirect()->route('seller.poListing.view');

    }
    /*this block is for PO approval ends here*/


    /*this block is for PO rejection starts here*/
    public function reject($id)
    {
        $this->roleRepo->permissionName = 'seller.po.reject';
        $this->buyerRepo->uuid = $id;
        $this->buyerRepo->status = "4";
        $permissionId = $this->roleRepo->p_getData();
        $roleId = session('role_id');

        if($permissionId && $roleId)
            $roleHasPermission = $this->roleRepo->checkRolePermission($permissionId->id, $roleId);
        else
            $roleHasPermission = false;

        if($roleHasPermission){
           $this->buyerRepo->changePOstatus();
        }
        return redirect()->route('seller.poListing.view');
    }
    /*this block is for PO rejection ends here*/

    /*Upload Attachment*/
    public function upload(Request $request)
    {
        $poData = $this->buyerRepo->uploadAttachment($request);
        return redirect()->route('seller.poListing.view');
    }
    
}

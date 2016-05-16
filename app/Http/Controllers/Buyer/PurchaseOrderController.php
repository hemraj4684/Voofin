<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;

use Auth,Input,URL,Excel,Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\BuyerInterface;
use Repository\RoleInterface;
use Response;
use DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public $buyerRepo;
    public $roleRepo;
    public $currencyData;
    public $loggedInUser;

    public function __construct(BuyerInterface $buyerRepo, RoleInterface $roleRepo)
    {
        $this->buyerRepo                = $buyerRepo;
        $this->roleRepo                 = $roleRepo;
        $this->buyerRepo->buyerId       = session('company_id');
        $this->buyerRepo->compConf      = json_decode(session('company_conf'),TRUE);
        $this->buyerRepo->compConf      = $this->buyerRepo->compConf[session('typeUser')];
        $this->buyerRepo->folder        = "purchase_order";
        $this->buyerRepo->variousStates = loadJSON('variousStatus'); 
        $this->currencyData             = loadJSON('Common-Currency');
        $this->buyerRepo->loggedInUser  = session('userId');
    }

    public function index()
    {
            if(Input::has('excelSearchButton')){
                Excel::create('poFile', function($excel){
                    $excel->sheet('poFile1', function($sheet){
                        $this->buyerRepo->po = true; //this is for accessing po related functions from BuyerRepo
                        $poList = $this->buyerRepo->getData();
                        $sellerList = $this->buyerRepo->getDataCompany();
                        $statusData['status'] = $this->buyerRepo->variousStates['PO']['Buyer'];
                        $statusData['symbols'] = $this->buyerRepo->variousStates['SYMBOLS'];
                        $currencyData = $this->currencyData;
                        $sheet->loadView('buyer.po.poExcel',compact('poList','sellerList','currencyData','statusData'));
                    });
                })->export('csv');
                //return $shetloadView('buyer.po.poListing', compact('poList','sellerList','currencyData','statusData'));
            }
            else{
                $this->buyerRepo->po = true; //this is for accessing po related functions from BuyerRepo
                $poList = $this->buyerRepo->getData();
                $sellerList = [];$this->buyerRepo->getDataCompany();
                $statusData['status'] = $this->buyerRepo->variousStates['PO']['Buyer'];
                $statusData['symbols'] = $this->buyerRepo->variousStates['SYMBOLS'];
                $currencyData = $this->currencyData;
                return view('buyer.po.poListing', compact('poList','sellerList','currencyData','statusData'));
            }
        
    }

    public function autocomplete()
    {
        $this->buyerRepo->keyword = Input::get('term');
        $data = $this->buyerRepo->getData();
        return json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $configuration['paymentTerms'] = $this->buyerRepo->compConf['other_configuration']['payment_terms']; //taking payment terms from database
        $configuration['currency']     = $this->buyerRepo->compConf['other_configuration']['currency']; //taking currency from database
        $currencyData                  = $this->buyerRepo->loadCurrencyJSON('Common-Currency');
        return view('buyer.po.poManage',compact('configuration','currencyData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->buyerRepo->userId = session('userId');
        $success = $this->buyerRepo->store($request);
        Session::flash('message', $this->buyerRepo->message);
        return Response::json($success,200);
        /*if($this->buyerRepo->success)
            return redirect()->route('buyer.poListing.view');
        else
            return redirect()->route('buyer.po.add');*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        return view('buyer.po.poModal');   
    }

    public function show($id)
    {
        
        $this->buyerRepo->uuid = $id;
        $poData = $this->buyerRepo->getData();
        //dd($poData->buyer_id);
        if($poData){
            $this->buyerRepo->sellerId = $poData->buyer_id;
            $buyerData = $this->buyerRepo->getDataCompany();

            $this->buyerRepo->sellerId = $poData->seller_id;
            $sellerData = $this->buyerRepo->getDataCompany();

            $this->buyerRepo->poId = $poData->id;
            $poItemData = $this->buyerRepo->getPOItem();
            $poAttachData = $this->buyerRepo->getPOAttachment();
            $statusData['status'] = $this->buyerRepo->variousStates['PO']['Buyer'];
        }
        
        return view('buyer.includes.poModal', compact('poData','buyerData','sellerData','poItemData','poAttachData','statusData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$this->buyerRepo->po = true;
        $this->buyerRepo->uuid = $id;
        $poData = $this->buyerRepo->getData();
        if($poData->invYN !== 'N'){
           $nonEditMsg = "PO number $poData->purchase_order_number is non editable because it has invoice";
           return redirect()->route('buyer.poListing.view')->with('nonEditMsg', $nonEditMsg);
        }

        $this->buyerRepo->sellerId = $poData->seller_id;
        $sellerData = $this->buyerRepo->getDataCompany();

        $this->buyerRepo->poId = $poData->id;
        $poItemData = $this->buyerRepo->getPOItem();
        $poAttachData = $this->buyerRepo->getPOAttachment();
        $currencyData = $this->buyerRepo->loadCurrencyJSON('Common-Currency');
        return view('buyer.po.poManage', compact('poData','sellerData','poItemData','poAttachData','currencyData'));
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
        $this->buyerRepo->deletePo = true;
        $this->buyerRepo->uuid = $id;
        $this->buyerRepo->changeStatus();
        return redirect()->route('buyer.poListing.view');
    }

    /**
     * Delete the invoice attachment the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAttachment($id)
    {
        $this->buyerRepo->attachId = $id;
        $poData = $this->buyerRepo->changeStatus();
        return $poData;
    }

    /*this block is for PO approval strats here*/
    public function approve($id)
    {   
        //$this->roleRepo->permissionName = 'buyer.po.approve';
        $this->buyerRepo->uuid = $id;
        $this->buyerRepo->status = "1";
        /*$permissionId = $this->roleRepo->p_getData();
        $roleId = session('role_id');

        if($permissionId && $roleId)
            $roleHasPermission = $this->roleRepo->checkRolePermission($permissionId->id, $roleId);
        else
            $roleHasPermission = false;*/

        if(\Entrust::can('buyer.po.approve')){
           $this->buyerRepo->changePOstatus();
        }

        Session::flash('message', $this->buyerRepo->message);
        return redirect()->route('buyer.poListing.view');

    }
    /*this block is for PO approval ends here*/


    /*this block is for PO rejection starts here*/
    public function reject($id)
    {
        //$this->roleRepo->permissionName = 'buyer.po.reject';
        $this->buyerRepo->uuid = $id;
        $this->buyerRepo->status = "2";
        /*$permissionId = $this->roleRepo->p_getData();
        $roleId = session('role_id');

        if($permissionId && $roleId)
            $roleHasPermission = $this->roleRepo->checkRolePermission($permissionId->id, $roleId);
        else
            $roleHasPermission = false;
*/
        if(\Entrust::can('buyer.po.reject')){
           $this->buyerRepo->changePOstatus();
           Session::flash('message', $this->buyerRepo->message);
        }
        return redirect()->route('buyer.poListing.view');
    }
    /*this block is for PO rejection ends here*/
    public function upload(Request $request)
    {
        $poData = $this->buyerRepo->uploadAttachment($request);
        return redirect()->route('buyer.poListing.view');
    }

    public function poPresentYN(Request $request){
         $poNumber = $request->purOrderNumber;
         $yn = $this->buyerRepo->poPresentYN($poNumber);
         if($yn !== null)
            return response()->json(['success' => 'PO Number already exist! Please use another Number']);
         else
            return response()->json(['error' => 'PO Number not exist']);
    }

    
}

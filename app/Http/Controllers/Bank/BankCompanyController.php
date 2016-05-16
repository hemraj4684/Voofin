<?php

namespace App\Http\Controllers\bank;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\CompanyInterface;
use Repository\RoleInterface;
use URL,Input;

class BankCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $compRepo;
    public $roleRepo;

    public function __construct(CompanyInterface $compRepo,  RoleInterface $roleRepo)
    {
        $this->compRepo = $compRepo;    
        $this->compRepo->loggedInUser = session('userId');
        $this->roleRepo = $roleRepo;    
    }

    public function index()
    {
        $this->compRepo->keywords = $keyword = Input::get('search_box');
        $this->compRepo->companyType = array(Input::get('company_type_search'));
        $this->compRepo->status = $status = Input::get('status');
        $comps = $this->compRepo->getCompanies();
        $comps->setPath(URL::route('bank.company.view'));   
        return view('bank.company.companyListing', compact('comps'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->compRepo->userType = roleId('Bank');
        $this->roleRepo->isBank = TRUE;
        $roles = $this->roleRepo->getRoles();
        return view('bank.company.manageCompany', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->uuid)
            $this->compRepo->uuid = $request->uuid;  // this is for record updation code checking
        $data = $this->compRepo->save($request);
        echo json_encode($data);
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
        //session(['uuid' => $id]);
        $this->compRepo->uuid = $id;
        $comp = $this->compRepo->getCompanies();   
        //$this->compRepo->userType = roleId('Bank');
        $this->roleRepo->isBank = TRUE;
        $roles = $this->roleRepo->getRoles();
        return view('bank.company.manageCompany', compact('comp','roles'));
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
    public function changeStatus()
    {
        $this->compRepo->uuid = Input::get('id');
        $comp = $this->compRepo->changeStatus(); 
    }
}

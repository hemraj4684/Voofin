<?php

namespace App\Http\Controllers\bank\company;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\CompanyInterface;
use URL,Input;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $compRepo;

    public function __construct(CompanyInterface $compRepo)
    {
        $this->compRepo = $compRepo;    
    }

    public function index()
    {
        $this->compRepo->keywords = $keyword = Input::get('search_box');
        $this->compRepo->companyType = Input::get('company_type_search');
        $this->compRepo->status = $status = Input::get('status');
        $comps = $this->compRepo->getCompanies();
        $comps->setPath(URL::route('company.view'));   
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
        $roles = $this->compRepo->getRoles();
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
        session(['uuid' => $id]);
        $this->compRepo->uuid = $id;
        $comp = $this->compRepo->getCompanies();   
        //$this->compRepo->userType = roleId('Bank');
        $roles = $this->compRepo->getRoles();
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

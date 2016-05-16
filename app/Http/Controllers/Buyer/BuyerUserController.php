<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
use Auth,Input,URL;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\UserInterface;


class BuyerUserController extends Controller
{
    public $userRepo;
    public function __construct(UserInterface $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->userRepo->companyId = session('company_id');
        $this->userRepo->loggedInUser  = session('userId');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->userRepo->keywords = $keyword = Input::get('search_box');
        $this->userRepo->userType = $user_type = array(roleId('Buyer'));
        $this->userRepo->status = $status = Input::get('status');
        $users = $this->userRepo->getUsers();
        /*$this->userRepo->userType = "buyer";
        $roles = $this->userRepo->getRoles();*/
        $users->setPath(URL::route('buyer.user.view'));
        return view('buyer.user.userListing',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->userRepo->userType = roleId('Buyer');
        $roles = $this->userRepo->getRoles();
        return view('buyer.user.manageUser',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->userRepo->userType='company';
        $data = $this->userRepo->save($request);
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
        $data = $this->userRepo->save($request);
        echo json_encode($data);
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
        $this->userRepo->uuid = $id; 
        $user = $this->userRepo->getUsers();
        $this->userRepo->userType = roleId('Buyer');
        $roles = $this->userRepo->getRoles();
        return view('buyer.user.manageUser',compact('user','roles'));
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

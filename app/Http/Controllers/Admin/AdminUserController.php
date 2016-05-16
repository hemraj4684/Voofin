<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth, Input, URL;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\UserInterface;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $userRepo;

    public function __construct(UserInterface $userRepo) 
    {
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $this->userRepo->keywords = $keyword = Input::get('search_box');
        $this->userRepo->userType = $user_type = Input::get('user_type_search');
        $this->userRepo->status = $status = Input::get('status');
        $users = $this->userRepo->getUsers();
        $roles = $this->userRepo->getRoles();
        
        return view('admin.user.userListing',compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->userRepo->userType = array(0,1,2,3,4);
        $roles = $this->userRepo->getRoles();
        return view('admin.user.manageUser', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $this->userRepo->save($request);
        echo json_encode($data);
    }
    
    public function show($id) {
        $data = $this->userRepo->save($request);
        echo json_encode($data);
    }
    
    public function edit($id) {
        session(['uuid' => $id]);
        $this->userRepo->uuid = $id;
        $user = $this->userRepo->getUsers();
        //$this->userRepo->userType = "6";
        $roles = $this->userRepo->getRoles();
        return view('admin.user.manageUser', compact('user', 'roles'));
    }
    
    public function updatePassword(Request $request) {
        $this->userRepo->userId = session('userId');
        $data = $this->userRepo->updatePassword($request);
        Session::flush();
        echo json_encode($data);
    }

    public function changeStatus()
    {
        $this->userRepo->uuid = Input::get('id');
        $user = $this->userRepo->changeStatus(); 
    }
}

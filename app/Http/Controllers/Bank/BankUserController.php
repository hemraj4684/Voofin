<?php
namespace App\Http\Controllers\Bank;

use Illuminate\Http\Request;
use Auth, Input, URL;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Repository\UserInterface;
use Session;
class BankUserController extends Controller
{
    public $userRepo;
    public function __construct(UserInterface $userRepo) {
        $this->userRepo = $userRepo;
        $this->userRepo->loggedInUser  = session('userId');
    }
    
    public function index($id = null) {
        
        $this->userRepo->keywords = $keyword = Input::get('search_box');
        $this->userRepo->user_type = $user_type = Input::get('user_type_search');
        $this->userRepo->status = $status = Input::get('status');
        if ($id) {
           $this->userRepo->companyUUID = $id;
        } 
        else {
           $this->userRepo->allRecord = true;
        }
        $users = $this->userRepo->getUsers();
        $roles = $this->userRepo->getRoles();
        
        return view('bank.user.userListing',compact('users','roles'));
    }
    
    public function create() {
        $roles = $this->userRepo->getRoles();
        return view('bank.user.manageUser', compact('roles'));
    }
    
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
        //$this->userRepo->userType = roleId('Bank');
        $roles = $this->userRepo->getRoles();
        return view('bank.user.manageUser', compact('user', 'roles'));
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

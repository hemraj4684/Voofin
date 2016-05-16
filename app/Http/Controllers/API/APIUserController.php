<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth,Response;
use Repository\UserInterface;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Crypt, Input;
class APIUserController extends Controller
{
    public $userRepo;
    public $userData;
    public function __construct(UserInterface $userRepo) {
        $userRepo->authToken = $authToken = app('request')->header('X-Auth-Token');
        $this->userRepo = $userRepo;
        $this->userData = $userRepo->getUserAuthData();
        $this->userData->configurations = json_decode($this->userData->configurations,true);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getUserInfo(){
        return Response::json($this->userData, 200)->header('Content-Type', 'application/json');
    }

    public function getPermission(){
        $this->userRepo->roleId = $this->userData->role_id;
        $data = $this->userRepo->getPermission();
        return Response::json($data, 200)->header('Content-Type', 'application/json');
    }

    public function getBankConfiguration() {
        $data = loadJSON('results');
        return Response::json($data, 200)->header('Content-Type', 'application/json');
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

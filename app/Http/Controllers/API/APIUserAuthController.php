<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User, Crypt, Input;
use Auth,Response;
use Repository\UserInterface;
class APIUserAuthController extends Controller
{
    public $userRepo;
    public function __construct(UserInterface $userRepo) {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->userRepo = $userRepo;
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

    public function postLogin(Request $request){
        if(!$request->email && !$request->password){
            return response('', 401);
        }
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email',$email)->first();
        if($user){

            $password = $user->salt.$password;

            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                
                $this->userRepo->email = $user->email;
                $userData = $this->userRepo->getUserByAttribute();
                return Response::json([], 200)->header('X-Auth-Token', $user->auth_token)->header('X-Auth-Type',roleType($userData->type));
                //return response(NULL,200)->header('X-Auth-Token', $user->auth_token)->header('X-Auth-Type',roleType($userData->type));
            }
            return response('', 401);
        }
        return response('', 401);
    }

    public function getUserInfo(){
        echo "user data";
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

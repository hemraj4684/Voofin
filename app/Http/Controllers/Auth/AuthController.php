<?php
namespace App\Http\Controllers\Auth;

use App\Models\User, Crypt, Input;
use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Repository\UserInterface;
use Uuid, Session;

class AuthController extends Controller
{
    protected $redirectPath = '/dashboard';
    protected $loginPath = '/login';
    public $userRepo;
    
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    public function __construct(UserInterface $userRepo) {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->userRepo = $userRepo;
    }
    
    public function getLogin() {
        return view('auth.login');
    }
    
    function postLogin() {
        
        $this->userRepo->email = $email = Input::get('email');
        $password = Input::get('password');

        $user = $this->userRepo->getUserByAttribute();
        
        if (isset($user->type) && $user->type) {
            
            $password = $user->salt . $password;
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                session(['userName' => $user->user_name,'userEmail' => $user->email,'userId' => $user->id, 'user_type' => $user->user_type,'role_id'=>$user->role_id, 'company_id'=>$user->company_id,'company_conf'=>$user->configurations]);
                
                switch ($user->type) {
                    case roleId('Bank'):

                        Session::put('typeUser', 'bank');
                        return redirect('/bank/dashboard');//bank
                        break;
                    case roleId('Buyer'):
                        Session::put('typeUser', 'buyer');
                        return redirect('/buyer/dashboard');//buyer
                        break;
                    case roleId('Seller'):
                        Session::put('typeUser', 'seller');
                        return redirect('/seller/dashboard');//seller
                        break;
                    case roleId('Both'):
                        Session::put('typeUser','both');
                        return redirect('/both/selection');//both
                        break;

                    case roleId('Admin'):
                        Session::put('typeUser', 'admin');
                        return redirect('/admin/dashboard');//admin
                        break;
                    default:
                        return "User Type is not correct";
                        break;
                }

            } 
            else {
                $error = "Password not matched";
                return view('auth/login', ['error' => $error]);
            }
        } 
        else {
            $error = "Email not matched";
            return view('auth/login', ['error' => $error]);
        }
    }
    
    function postRegister() {
        $this->create(Input::all());
    }
    
    protected function validator(array $data) {
        return Validator::make($data, ['name' => 'required|max:255', 'email' => 'required|email|max:255|unique:users', 'password' => 'required|confirmed|min:6', ]);
    }
    
    protected function create(array $data) 
    {
//        print_r($data);
        $salt = random();
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->salt = $salt;
        $user->uuid = Uuid::generate();
        $user->password = bcrypt($salt . $data['password']);
        $user->auth_token = Crypt::encrypt($salt .date('Y-m-d H:i:s'). $data['email']);
        $user->save();
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('/auth/login');
    }

    public function getresetPassword()
    {
        $withOutLogin = true;
        return view('admin.user.resetPassword', ['withOutLogin' => $withOutLogin]);
    }

    public function updatePassword(Request $request) 
    {
        if(!$request->email)
            $this->userRepo->userId = session('userId');
        $data = $this->userRepo->updatePassword($request);
        Session::flush();
        echo json_encode($data);
    }

    public function getUserType()
    {
        return view('seller.compTypeSel');               
    }

    public function postUserType()
    {
        if(Input::has('compTypeSel')){
            $compType = Input::get('compTypeSel');
            if ($compType === "buyer"){
               Session::put('typeUser', 'buyer'); 
               return redirect('/buyer/dashboard');//buyer
            }
            elseif ($compType === "seller"){
               Session::put('typeUser', 'seller'); 
               return redirect('/seller/dashboard');//seller
            }
        }
                       
    }

}

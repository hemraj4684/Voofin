<?php
namespace Repository\Eloquent;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Auth;
use Crypt;
use DB;
use Mail;
use Repository\UserInterface;
use Session;
use Uuid;
use Validator;

class UserRepo implements UserInterface
{
    public $userId      = '';
    public $uuid        = '';
    public $email       = '';
    public $password    = '';
    public $salt        = '';
    public $auth_token  = '';
    public $keywords    = '';
    public $userType    = '';
    public $user_type   = '';
    public $status      = '';
    public $companyId   = '';
    public $companyUUID = '';
    public $authToken   = null;
    public $roleId      = null;
    public $allRecord   = false;
    public $loggedInUser;
    
    public function getUsers()
    {
        return $this->getData();
    }

    public function getUserByAttribute()
    {
        $user = $this->getData();
        return $user;
    }

    public function getUserAuthData()
    {
        $query = User::orderBy('users.name', 'Asc');
        $query->join('roles', 'roles.id', '=', 'users.role_id');
        $query->leftJoin('companies', 'companies.id', '=', 'users.company_id');
        if($this->authToken)
            $query->where('users.auth_token', '=', $this->authToken);
        $query->select('users.name as user_name', 'users.salt', 'roles.type','users.id as loggedUserId','users.uuid as loggedUserUuid', 'users.status',
                'users.id', 'users.email', 'roles.name', 'users.uuid', 'users.user_type', 'users.role_id',
                'users.company_id', 'companies.id as comId', 'companies.configurations');
        $result = $query->first();
        $result->typeUser = strtolower(roleType($result->type));
        return $result;
    }

    public function getData()
    {
        $query = User::orderBy('users.name', 'Asc')
                //->join('roles', 'roles.id', '=', 'users.role_id')
            ->select('users.name as user_name', 'users.*', 'users.id as userId');

        if ($this->email || $this->userId || $this->uuid || $this->authToken) {
            if ($this->email) {

                $diffLogin = $query->where('users.email', '=', $this->email)->select('company_id')->first(); //checking for company id

                if ($diffLogin && $diffLogin->company_id) {
                    $query
                        ->join('roles', 'roles.id', '=', 'users.role_id')
                        ->join('companies', 'companies.id', '=', 'users.company_id')
                        ->where('users.email', '=', $this->email)
                        ->select('users.name as user_name', 'users.salt', 'roles.type', 'users.status',
                            'users.id', 'users.email', 'roles.name', 'users.uuid', 'users.user_type', 'users.role_id',
                            'users.company_id', 'companies.id as comId', 'companies.configurations')
                        ->get();
                } else {
                    $query->join('roles', function ($join) {
                        $join->on('roles.id', '=', 'users.role_id')->where('users.email', '=', $this->email);
                    })->select('users.name as user_name', 'users.salt', 'roles.type', 'users.status', 'users.id',
                        'users.email', 'roles.name', 'users.uuid', 'users.user_type', 'users.role_id', 'users.company_id')->get();
                }

            }
            if ($this->userId) {
                $query->where('users.id', $this->userId);
            }

            if ($this->uuid) {
                $query->where('users.uuid', $this->uuid);
            }

            if ($this->authToken) {
                $query->where('users.auth_token', $this->authToken);
            }

            $result = $query->first();

        } else {

            if ($this->companyId) {
                $query->join('companies', function ($join) {
                    $join->on('users.company_id', '=', 'companies.id')->where('companies.id', '=', $this->companyId);
                })->select('users.id as user_id','users.name as user_name', 'users.status', 'users.email', 'users.uuid', 'users.user_type', 'users.role_id')->get();
            }
            if ($this->companyUUID) {
                $query->join('companies', function ($join) {
                    $join->on('users.company_id', '=', 'companies.id')->where('companies.uuid', '=', $this->companyUUID);
                })->select('users.name as user_name', 'users.status', 'users.email', 'users.uuid', 'users.user_type', 'users.role_id')->get();
            }
            if ($this->keywords) {
                // dd($this->keywords);
                $query->whereRaw("(users.name like '%$this->keywords%' || users.email like '%$this->keywords%')");
            }

            if (isset($this->userType) && !empty($this->userType)) {

                if (is_array($this->userType)) {
//if user is buyer or seller then userType must be array i.e.(buyer, both) this block must run
                    $query->join('roles', function ($join) {
                        $join->on('roles.id', '=', 'users.role_id')
                            ->whereIn('roles.type', $this->userType);
                    })->select('users.name as user_name', 'users.status', 'users.email', 'roles.name', 'users.uuid', 'users.user_type', 'users.role_id')->get();
                } else {
//if user is not buyer or seller then userType must be string i.e. bank or admin this block must run
                    $query->join('roles', function ($join) {
                        $join->on('roles.id', '=', 'users.role_id')
                            ->where('roles.type', '=', $this->userType);
                    })->select('users.name as user_name', 'users.status', 'users.email', 'roles.name', 'users.uuid', 'users.user_type', 'users.role_id')->get();
                }
            }
            if (isset($this->user_type) && !empty($this->user_type)) {
                $query->where('users.user_type', '=', $this->user_type);
            }

            if (isset($this->status) && ($this->status === "0" || $this->status === "1")) {
                $query->where('users.status', $this->status);
            }
            if($this->allRecord)
                $query->join('roles', 'roles.id', '=', 'users.role_id')
                      ->addSelect('roles.name','roles.display_name');

           
            $result = $query->paginate(15);

        }
        return $result;
    }

    public function getRoles()
    {
        if (isset($this->userType) && !empty($this->userType)) {
            return $role = Role::where('roles.type', '=', $this->userType)->where('roles.company_id', '=', $this->companyId)->orderBy('name')->lists('name', 'id');
        } else {
            return $role = Role::orderBy('roles.name', 'Asc')->lists('name', 'id');
        }

    }

    public function save($data)
    {
        $jsonArray['error'] = 'error';
        if ($data['uuid']) {
            $rules = array('name' => 'required');
        } else {
            $rules = array('name' => 'required', 'email' => 'required|email|unique:users,email');
        }

        $validator = Validator::make($data->all(), $rules);
        if ($validator->fails()) {
            $messaages = $validator->messages();
            foreach ($rules as $key => $val) {
                $jsonArray[$key . 'Err'] = $messaages->first($key);
            }
        } else {
            if ($data['uuid']) {
                if ($data['uuid'] == session('uuid')) {
                    $user['name'] = $data->name;
                    if (isset($this->userType) && !empty($this->userType)) {
                        $user['user_type'] = $this->userType;
                    } else {
                        $user['user_type'] = $data->user_type;
                    }
                    $user['status']  = $data->status;
                    $user['role_id'] = $data->role;
                    if ($this->companyId) {
                        $user['company_id'] = $this->companyId;
                    }

                    $user['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $user['updated_by'] = $this->loggedInUser;
                    User::where('uuid', $data['uuid'])->update($user);
                    $user = User::where('uuid', $data['uuid'])->first();
                    DB::table('role_user')->where('user_id', $user->id)->delete();
                    $user->roles()->attach($data->role);
                    $jsonArray['error'] = 'success';
                }
            } else {
                $salt          = random();
                $user          = new User;
                $user->uuid    = Uuid::generate();
                $user->name    = $data->name;
                $user->email   = $data->email;
                $user->created_by = $this->loggedInUser;
                $user->role_id = $data->role;
                if (isset($this->userType) && !empty($this->userType)) {
                    $user->user_type = $this->userType;
                } else {
                    $user->user_type = $data->user_type;
                }
                if ($this->companyId) {
                    $user->company_id = $this->companyId;
                }

                $user->status     = $data->status;
                $user->salt       = $salt;
                $user->password   = bcrypt($salt . $salt);
                $user->auth_token = Crypt::encrypt($salt .date('Y-m-d H:i:s'). $data['email']);
                $user->ip_address = $_SERVER['REMOTE_ADDR'];

                //for role_user tabel save

                /* $roleuser = new RoleUser;
                $roleuser->user_id = $user->id;
                $roleuser->role_id = $user->id;*/

                $user->save();
                $user = User::find($user->id);
                $user->roles()->attach($data->role);

                $jsonArray['error'] = 'success';

                //$this->sendEmailReminder($data['email']);
                $this->sendEmailReminder($data['email']);
                //email to user for changing password
            }
        }
        return $jsonArray;
    }

    public function sendEmailReminder($user)
    {
        Mail::send('emails.email', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@app.com', 'Your Application');
            $m->to($user, 'test')->subject('Your Reminder!');
        });
    }

    public function updatePassword($data)
    {
        $jsonArray['error'] = 'error';
        if (isset($data->email)) {
            $rules = array('email' => 'required|email|exists:users,email', 'password' => 'required|min:3|confirmed', 'password_confirmation' => 'required|min:3');
        } else {
            $rules = array('oldPassword' => 'required', 'password' => 'required|min:3|confirmed', 'password_confirmation' => 'required|min:3');
        }
        $validator = Validator::make($data->all(), $rules);
        if ($validator->fails()) {
            $messaages = $validator->messages();
            foreach ($rules as $key => $val) {
                $jsonArray[$key . 'Err'] = $messaages->first($key);
            }
        } else {
            if (isset($data->email)) {
                $this->email    = $data->email;
                $user           = $this->getData();
                $user->password = bcrypt($user->salt . $data['password']);
                $user->save();
                $jsonArray['error'] = 'success';
            } else {
                $user = $this->getData();
                if ($user) {
                    $oldPassword = $user->salt . $data['oldPassword'];
                    $credentials = ['email' => $user->email, 'password' => $oldPassword];
                    if (Auth::validate($credentials)) {
                        $user           = User::find($this->userId);
                        $user->password = bcrypt($user->salt . $data['password']);
                        $user->save();
                        $jsonArray['error']          = 'success';
                        $jsonArray['oldPasswordErr'] = '';
                    } else {
                        $jsonArray['error']          = 'error';
                        $jsonArray['oldPasswordErr'] = 'Please enter valid password';
                    }
                }
            }

        }
        return $jsonArray;
    }

    public function changeStatus()
    {
        $status = User::where('uuid', $this->uuid)->firstOrFail();

        if ($status->status === "1") {
            User::where('uuid', $this->uuid)
                ->update(['status' => 0]);
            return "active";
        } elseif ($status->status === "0") {
            User::where('uuid', $this->uuid)
                ->update(['status' => 1]);
            return "inactive";
        }
        return false;
    }

    public function getPermission(){
        $query = Permission::join('permission_role','permission_role.permission_id','=','permissions.id');
        $query->select('name');
        $query->where('permission_role.role_id',$this->roleId);
        $query->get();
        return $query->get();
    }
}

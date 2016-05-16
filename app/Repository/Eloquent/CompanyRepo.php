<?php
namespace Repository\Eloquent;

use Mail, Validator, Crypt, Request, Input;
use Uuid, Session;
use Repository\CompanyInterface;
use App\Models\Company;
use App\Models\User;
use App\Models\Role;
use App\Models\CompanyBank;
use DB,URL;

class CompanyRepo Implements CompanyInterface
{
    public $uuid = '';
    public $email = '';
    public $salt = '';
    public $auth_token = '';
    public $keywords = '';
    public $companyType = '';
    public $status = '';
    public $userType = '';
    public $loggedInUser;
    
    public function getCompanies() {
        return $this->getData();
    }
    
    function loginUser($data) {
        
        //dd($data);
        
        
    }
    
    public function getUserByAttribute() {
        $user = $this->getData();
        return $user;
    }
    
    public function getData() {
        $query = Company::orderBy('companies.name', 'Asc');

        if ($this->uuid) {
            $query
                ->leftJoin('company_banks', 'company_banks.company_id', '=', 'companies.id')
                ->join('users', 'users.company_id', '=', 'companies.id')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->select('companies.name as compName', 'companies.uuid as compuuid','companies.*', 'users.*', 'company_banks.*', 'roles.id as roleId', 
                    'companies.id as compId', 'users.id as userId', 'company_banks.id as combnkId', 'companies.status as comStatus')
                ->where('companies.uuid', $this->uuid);
            $result = $query->first();
        } 
        else {
            if($this->keywords){
               $query->whereRaw("(companies.name like '%$this->keywords%')");
            }

            if(is_array($this->companyType)&& !empty(array_filter($this->companyType))){
               $query->whereIn('companies.industry',$this->companyType);
            }

            if(isset($this->status) && ($this->status === "0" || $this->status === "1")){
                $query->where('status',$this->status);
            }

            $result = $query->paginate(15);
            //dd(URL::route('company.view'));

        }

        //dd($result, $query->toSql());
        return $result;
    }
    
    public function getRoles(){
        if($this->userType)
            return  $role = Role::whereIn('roles.type', '=', $this->userType)->orderBy('name')->lists('name', 'id');
        else {
            return  $role = Role::orderBy('name')->lists('name', 'id');
        }
    }
    
    public function save($data) {
        $jsonArray['error'] = 'error';
        if ($data['uuid'])
            $rules = array('compName' => 'required');//for edit purpose rules
        else
            $rules = array('compName' => 'required', 'compType' => 'required', 'company_details' => 'required|unique:companies,identification_no', 
                           'compRegNum' => 'required|unique:companies,registration_no', 'panNum' => 'required','email' => 'required|email|unique:users,email');

        $validator = Validator::make($data->all(), $rules);
        if ($validator->fails()) {
            $messaages = $validator->messages();
            foreach ($rules as $key => $val) {
                $jsonArray[$key . 'Err'] = $messaages->first($key);
            }
        } 
        else {
                
            DB::beginTransaction();

            try{
                if ($data['uuid'] && ($data['uuid'] === $this->uuid)) { //this block is for record updation
                    $dataId = $this->getData();
                    //$comp = Company::where('uuid', $dataId->uuid)->first();
                    $comp = Company::find($dataId->compId);
                    $user = User::find($dataId->userId);
                    $user->updated_by = $this->loggedInUser;
                    $comp->updated_by = $this->loggedInUser;
                    $cmpbnk = CompanyBank::find($dataId->combnkId);
                    $user->roles()->detach($data->role);
                }
            
                else { //this block is for record save
                    $comp = new Company; //company records save 
                    $user = new User;//1st user related to company records save 
                    $cmpbnk = new CompanyBank; //company bank  records save     
                    $comp->uuid = Uuid::generate();
                    $user->uuid = Uuid::generate();
                    $salt = random();
                    $user->salt = $salt;
                    $user->auth_token = Crypt::encrypt($salt . $data['email']);
                    $user->password = bcrypt($salt . $salt);
                    $user->created_by = $this->loggedInUser;
                    $comp->created_by = $this->loggedInUser;
                }

                $comp->name = $data->compName;
                $comp->city = $data->city;
                $comp->state = $data->state;
                $comp->pincode = $data->pincode;
                $comp->address = $data->address;
                $comp->status = $data->status;
                $comp->identification_no = $data->company_details;
                $comp->organisation_type = $data->compType;
                $comp->registration_no = $data->compRegNum;
                $comp->pan = $data->panNum;
                $comp->industry = $data->comp_type;
                 
                $user->name = $data->contactUser;
                $user->email = $data->email;
                $user->role_id = $data->role;
                $user->user_type = 'company';
                $user->ip_address = $_SERVER['REMOTE_ADDR'];

                $user->save();
                $user->roles()->attach($data->role);
                $comp->contact_user_id = $user->id;
                
                //Defualt Company configuration 
                if(isset($data->comp_type) && $data->comp_type == roleId('Buyer')){
                    $comp->configurations = '{"buyer":{"price_band":{"":""},"tax_configuration":{"VAT":"5","CST":"5"},"other_configuration":{"payment_terms":"","erp_integration":null,"currency":"BDT"},"maker_checker":{"po_creation":null,"invoice_approval":null,"pi_upload":null}}}';
                }
                elseif(isset($data->comp_type) && $data->comp_type == roleId('Seller')){
                    $comp->configurations = '{"seller":{"tax_configuration":{"VAT":"2","CST":"2"},"maker_checker":{"invoice_creation":"0","manual_discoutning":"1"},"other_configuration":{"auto_discounting":"1","auto_accept_po":"1"}}}';
                }
                elseif(isset($data->comp_type) && $data->comp_type == roleId('Both')){
                    $comp->configurations = '{"buyer":{"price_band":{"":""},"tax_configuration":{"VAT":"12","CST":"5"},"other_configuration":{"payment_terms":"","erp_integration":null,"currency":"BDT"},"maker_checker":{"po_creation":null,"invoice_approval":null,"pi_upload":null}},"seller":{"tax_configuration":{"VAT":"2","CST":"2"},"maker_checker":{"invoice_creation":"0","manual_discoutning":"1"},"other_configuration":{"auto_discounting":"1","auto_accept_po":"1"}}}';
                }
                $comp->save();
                
                //this will update users tabel company_id with updated company ID
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['company_id' => $comp->id]);
                
                $cmpbnk->bank_name = $data->bankName;
                $cmpbnk->branch = $data->branch;
                $cmpbnk->account_no = $data->accNo;
                $cmpbnk->ifsc_code = $data->ifscCode;
                $cmpbnk->company_id = $comp->id;
                $cmpbnk->save();
                $jsonArray['error'] = 'success';
                //try
                
                $this->sendEmailReminder($data->email);
                //email to user for changing password
                DB::commit();
            }
            catch (\Exception $e) {
                DB::rollback();
                $jsonArray['error'] = 'error';
                $jsonArray['errorMsg'] = $e;
                // something went wrong
            }
            
        }
        return $jsonArray;
    }
    
    public function sendEmailReminder($user) {
        Mail::send('emails.email', ['user' => $user], function ($m) use ($user) {
            $m->from('contact@geo.com', 'Veefin');
            $m->to($user, 'demo')->subject('Veefin user created');
        });
    }

    public function changeStatus(){
        $status = Company::where('uuid', $this->uuid)->firstOrFail();
        //dd($status->status);
        if($status->status === "1"){
            Company::where('uuid', $this->uuid)
                   ->update(['status' => 0]);
            return "active";           
        }
        elseif($status->status === "0"){
            Company::where('uuid', $this->uuid)
                   ->update(['status' => 1]);
            return "inactive";
        }
        return false;
    }
}
?>
<?php
namespace Repository\Eloquent;
use Repository\RoleInterface;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Navigation;
use Validator, Request, Input;
use Uuid, Session, DB, Route;
class RoleRepo implements RoleInterface
{
    public $roleId = '';
    public $uuid = '';
    public $p_uuid = '';
    public $isBank = false;
    public $permissionId = '';
    public $permissionName = '';
    public $n_uuid = '';
    public $navigationId = '';
    public $read = 0;
    public $write = 0;
    public $delete = 0;
    public $companyId = ""; //this is for company users
    public $type = ""; //this is for company users type for ex. Buyer, Seller to show records of particular type

    public function getRoles() {
        return $this->getData();
    }
    
    public function getRoleByAttribute() {
        return $this->getData();
    }
    
    function getData() {
        $query = Role::orderBy('name', 'Asc');
        if($this->companyId && $this->type)
           $query->where('type', $this->type)
                 ->where('company_id', $this->companyId);
        if($this->isBank){
            $query->whereRaw('company_id is NULL');
        }    
        if ($this->roleId) {
            $query->where('id', $this->roleId);
            $result = $query->first();
        } 
        elseif ($this->uuid) {
            $query->where('uuid', $this->uuid);
            $result = $query->first();
        }
        else {
            $result = $query->paginate(15);
        }
        return $result;
    }
    
    
    public function save($data) {
        $jsonArray['error'] = 'error';
        $rules = array('name' => 'required');
        $navigations = $this->getNavigations();
        
        $validator = Validator::make($data->all(), $rules);
        if ($validator->fails()) {
            $messaages = $validator->messages();
            foreach ($rules as $key => $val) {
                $jsonArray[$key . 'Err'] = $messaages->first($key);
            }
        } 
        else {
            $role = Role::findOrNew(Input::get('id'));
            if (!Input::get('id')) $role->uuid = Uuid::generate();
            $role->name = Input::get('name');
            $role->type = Input::get('type');
            $role->display_name = Input::get('display_name');
            if($this->companyId)
                $role->company_id = $this->companyId;
            $role->description = Input::get('description');
            $role->save();
            
            if (!empty(Input::get('chk'))) {
                $role->perms()->sync(Input::get('chk'));
            }
            
            $jsonArray['error'] = 'success';
        }
        return $jsonArray;
    }
    
    public function syncRolePermission() {
        foreach (Route::getRoutes() as $value) {
            $this->permissionName = $value->getName();
            if (!$this->p_getData()) {
                $displayName = ucwords(strtolower(str_replace(".", " ", $value->getName())));
                $permissions = new Permission();
                $permissions->uuid = Uuid::generate();
                $permissions->name = $value->getName();
                $permissions->display_name = $displayName;
                $permissions->save();
            }
        }
        return true;
    }
    
    public function checkNavAcl($navId, $roleId) {
        return $result = DB::table('user_acl')->where('navigation_id', $navId)->where('role_id', $roleId)->first();
    }
    
    /*for checking permission against role or vice verca starts here */

    public function checkRolePermission($permissionId, $roleId) {
        return $result = DB::table('permission_role')->where('permission_id', $permissionId)->where('role_id', $roleId)->first();
    }

    /*for checking permission against role or vice verca ends here */

    public function validation($request) {
        $rules = array('name' => 'required',);
        $validator = Validator::make($request->all(), $rules);
        return $jsonArray;
    }
    
    public function getPermissions() {
        return $this->p_getData();
    }
    
    public function getPermissionByAttribute() {
        return $this->p_getData();
    }
    
    public function p_getData() {
        $query = Permission::orderBy('name', 'Asc');
        if ($this->permissionId) {
            $query->where('id', $this->permissionId);
            $result = $query->first();
        } 
        elseif ($this->permissionName) {
            $query->where('name', $this->permissionName);
            $result = $query->first();
        } 
        elseif ($this->p_uuid) {
            $query->where('uuid', $this->p_uuid);
            $result = $query->first();
        } 
        else {
            $result = $query->get();
        }
        return $result;
    }
    
    public function p_save($data) {
        $jsonArray['error'] = 'error';

        $rules = array('name' => 'required',);
        $validator = Validator::make($data->all(), $rules);
        if ($validator->fails()) {
            $messaages = $validator->messages();
            foreach ($rules as $key => $val) {
                $jsonArray[$key . 'Err'] = $messaages->first($key);
            }
        } 
        else {
            if ($data['uuid']) {
                if ($data['uuid'] == session('p_uuid')) {
                    $role['name'] = $data->name;
                    $role['display_name'] = $data->display_name;
                    $role['description'] = $data->description;
                    Permission::where('uuid', $data['uuid'])->update($role);
                    $jsonArray['error'] = 'success';
                    
                }
            } 
            else {
                $role = new Permission;
                $role->uuid = Uuid::generate();
                $role->name = $data->name;
                $role->display_name = $data->display_name;
                $role->description = $data->description;
                $role->save();
                $jsonArray['error'] = 'success';
            }
        }
        
        return $jsonArray;
    }
    
    public function getNavigations() {
        return $this->n_getData();
    }
    
    public function getNavigationsByAttribute() {
        return $this->n_getData();
    }
    
    public function n_getData() {
        $query = Navigation::orderBy('name', 'Asc');
        if ($this->permissionId) {
            $query->where('id', $this->navigationId);
            $result = $query->first();
        } 
        elseif ($this->n_uuid) {
            $query->where('uuid', $this->n_uuid);
            $result = $query->first();
        } 
        else {
            $result = $query->paginate(15);
        }
        return $result;
    }
    
    public function n_save($data) {
        $jsonArray['error'] = 'error';
        $rules = array('name' => 'required',);
        $validator = Validator::make($data->all(), $rules);
        if ($validator->fails()) {
            $messaages = $validator->messages();
            foreach ($rules as $key => $val) {
                $jsonArray[$key . 'Err'] = $messaages->first($key);
            }
        } 
        else {
            
            if ($data['uuid']) {
                if ($data['uuid'] == session('n_uuid')) {
                    $role['name'] = $data->name;
                    $role['parent_id'] = $data->parent_id;
                    Navigation::where('uuid', $data['uuid'])->update($role);
                    $jsonArray['error'] = 'success';
                }
            } 
            else {
                $role = new Navigation;
                $role->uuid = Uuid::generate();
                $role->name = $data->name;
                $role->parent_id = $data->parent_id;
                $role->save();
                $jsonArray['error'] = 'success';
            }
        }
        return $jsonArray;
    }

    
}
?>
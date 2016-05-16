<?php
namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use Auth, Input;
use App\Http\Requests;

use Repository\RoleInterface;
use Uuid, DB, Redirect;
use Session, Route;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
//use Redis;
class SellerRoleController extends Controller
{
    public $roleRepo;
    public function __construct(RoleInterface $roleRepo) {
        $this->roleRepo = $roleRepo;
        $this->roleRepo->companyId = session('company_id');
        $this->roleRepo->type = roleId('Seller');
    }
    
    public function index() {
   //      echo 'test';
     //    Redis::set('name', 'Taylor');
       //echo  Redis::get('name');
        $roles = $this->roleRepo->getRoles();
        return view('seller/role/roleListing', compact('roles'));
    }
    
    public function create() {
        $navigations = [];//$this->getNavArray($this->roleRepo->getNavigations());
        $permissions = $this->roleRepo->getPermissions();
        $role = new Role();
        return view('seller/role/manageRole', compact('navigations', 'permissions', 'role'));
    }
    
    public function store(Request $request) {
        $data = $this->roleRepo->save($request);
        echo json_encode($data);
    }
    
    public function edit($id) {
        session(['uuid' => $id]);
        $this->roleRepo->uuid = $id;
        $role = $this->roleRepo->getRoleByAttribute();
        $this->roleRepo->roleId = $role->id;
        $permissions = $this->roleRepo->getPermissions();
        $role = $role = Role::find($role->id);
        return view('seller/role/manageRole', compact('navigations', 'permissions', 'role'));
    }
    
    public function syncRolePermission() {
        $this->roleRepo->syncRolePermission();
        return redirect()->route('bank.permission.view');
        //return $this->p_index();
    }
    
    public function p_index() {
        $permissions = $this->roleRepo->getPermissions();
        return view('bank/permission/permissionListing', compact('permissions'));
    }
    
    public function p_create() {
        return view('bank/permission/managePermission');
    }
    
    public function p_store(Request $request) {
        $data = $this->roleRepo->p_save($request);
        echo json_encode($data);
    }
    
    public function p_edit($id) {
        session(['p_uuid' => $id]);
        $this->roleRepo->p_uuid = $id;
        $permission = $this->roleRepo->getPermissionByAttribute();
        return view('bank/permission/managePermission', compact('permission'));
    }
    
    public function n_index() {
        $navigations = $this->roleRepo->getNavigations();
        return view('bank/navigation/navigationListing', compact('navigations'));
    }
    
    public function n_create() {
        $parentNav = $this->roleRepo->getNavigations();
        return view('bank/navigation/manageNavigation', compact('parentNav'));
    }
    
    public function n_store(Request $request) {
        $data = $this->roleRepo->n_save($request);
        echo json_encode($data);
    }
    
    public function n_edit($id) {
        session(['n_uuid' => $id]);
        
        $parentNav = $this->roleRepo->getNavigations();
        $this->roleRepo->n_uuid = $id;
        $navigation = $this->roleRepo->getNavigationsByAttribute();
        return view('bank/navigation/manageNavigation', compact('navigation', 'parentNav'));
    }
}

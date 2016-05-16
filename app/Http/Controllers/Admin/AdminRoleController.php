<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Repository\RoleInterface;
use App\Http\Requests;
use App\Models\Permission;
use App\Models\Role;
use App\Http\Controllers\Controller;


class AdminRoleController extends Controller
{
    public $roleRepo;
    public function __construct(RoleInterface $roleRepo){
        $this->roleRepo = $roleRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //get Roles
       $roles = $this->roleRepo->getRoles();
       return view('admin/role/roleListing', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $navigations = [];//$this->getNavArray($this->roleRepo->getNavigations());
        $permissions = $this->roleRepo->getPermissions();
        $role = new Role();
        return view('admin/role/manageRole', compact('navigations', 'permissions', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $this->roleRepo->save($request);
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
        $this->roleRepo->uuid = $id;
        $role = $this->roleRepo->getRoleByAttribute();
        $this->roleRepo->roleId = $role->id;
        $permissions = $this->roleRepo->getPermissions();
        $role = $role = Role::find($role->id);
        return view('admin/role/manageRole', compact('navigations', 'permissions', 'role'));
    }
    public function syncRolePermission() {
        $this->roleRepo->syncRolePermission();
        return redirect()->route('admin.permission.view');
        //return $this->p_index();
    }
    
    public function p_index() {
        $permissions = $this->roleRepo->getPermissions();
        return view('admin/permission/permissionListing', compact('permissions'));
    }
    
    public function p_create() {
        return view('admin/permission/managePermission');
    }
    
    public function p_store(Request $request) {
        $data = $this->roleRepo->p_save($request);
        echo json_encode($data);
    }
    
    public function p_edit($id) {
        session(['p_uuid' => $id]);
        $this->roleRepo->p_uuid = $id;
        $permission = $this->roleRepo->getPermissionByAttribute();
        return view('admin/permission/managePermission', compact('permission'));
    }
    
    public function n_index() {
        $navigations = $this->roleRepo->getNavigations();
        return view('admin/navigation/navigationListing', compact('navigations'));
    }
    
    public function n_create() {
        $parentNav = $this->roleRepo->getNavigations();
        return view('admin/navigation/manageNavigation', compact('parentNav'));
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
        return view('admin/navigation/manageNavigation', compact('navigation', 'parentNav'));
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

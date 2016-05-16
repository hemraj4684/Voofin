<?php
namespace Repository;

interface RoleInterface {
    
    public function getRoles();
    public function getRoleByAttribute();
    public function getPermissions();
    public function getPermissionByAttribute();
    public function getNavigations();
    public function getNavigationsByAttribute();
    public function syncRolePermission();
}
?>
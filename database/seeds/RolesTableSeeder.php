<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Providers\RouteServiceProvider as RT;
//use \Route as RT;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //dd(RT::getRoutes()->nameList);
        // foreach (RT::getRoutes() as $value) {
        //    print_r($value->nameList);
        // }
        // die;
        $bank               = new Role();
        $bank->name         = 'bank';
        $bank->display_name = 'Bank Owner'; // optional
        $bank->description  = 'User is the owner of a given project'; // optional
        $bank->type         = '2';
        $bank->save();

        // foreach (Route::getRoutes() as $value) {
        //     if (strpos($value->getName, "bank.") !== false) {
        //         $displayName               = ucwords(strtolower(str_replace(".", " ", $value->getName())));
        //         $permissions               = new Permission();
        //         $permissions->uuid         = Uuid::generate();
        //         $permissions->name         = $value->getName();
        //         $permissions->display_name = $displayName;
        //         $permissions->save();
        //         $bank->attachPermission($permissions);
        //     }

        // }

        // DB::table('roles')->insert([
        //     'uuid' => 'admin',
        //     'name' => 'admin',
        //     'display_name' => 'admin',
        //     'type' => '2'
        // ]);
    }
}

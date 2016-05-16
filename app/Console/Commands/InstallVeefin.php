<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use DB;
use Route;
use Uuid;

class InstallVeefin extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:veefin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $excep = '';
        DB::beginTransaction();
        try {
            $role = new Role();
            $role->uuid = Uuid::generate();
            $role->name = 'bank';
            $role->display_name = 'Bank Owner'; // optional
            $role->description = 'User is the owner of a given project'; // optional
            $role->type = '2';
            $role->save();

            foreach (Route::getRoutes() as $value) {
                $permissionName = $value->getName();
                if ($permissionName) {
                    $query = Permission::orderBy('name', 'Asc');
                    $query->where('name', $permissionName);
                    $result = $query->first();
                    if (!$result) {
                        $displayName = ucwords(strtolower(str_replace(".", " ", $value->getName())));
                        $permissions = new Permission();
                        $permissions->uuid = Uuid::generate();
                        $permissions->name = $value->getName();
                        $permissions->display_name = $displayName;
                        $permissions->save();
                        $role->attachPermission($permissions);
//                        DB::table('permission_role')->insert([
//                            'permission_id' => $permissions->id,
//                            'role_id' => $role->id,
//                        ]);
                    }
                }
            }



            $salt = 'secret';
            $user = new User;
            $user->name = 'Bank Admin';
            $user->uuid = Uuid::generate();
            $user->email = 'bank@bank.com';
            $user->salt = $salt;
            $user->password = bcrypt($salt . 'secret');
            $user->user_type = 'bank';
            $user->role_id = $role->id;
            $user->status = '1';
            $user->save();
            $setUserRole = User::where('email', '=', 'bank@bank.com')->first();
            $setUserRole->attachRole($role);
            //$user->roles()->attach($user->id);
            $message = 'Veefin set up successfully';
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $excep = $e;
            $message = 'Error';
        }
        echo $message;
    }

}

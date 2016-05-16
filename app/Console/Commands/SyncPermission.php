<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Permission;
use App\Models\User;
use DB;
use Route;
use Uuid;

class SyncPermission extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:permission';

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
        $syncFlag = FALSE;
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
                    $syncFlag = TRUE;
                }
            }
        }
        if($syncFlag)
            echo "Permission Synced succefully.";
        else
            echo "Nothing to sync.";
    }

}

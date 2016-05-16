<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

use Session,Request,Response;
class ACL
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next) {
        $role = Role::find(Session::get('role_id'));
        $user = Session::get('typeUser');

        $per = $role->permissions()->get(['name'])->toArray();
        $curRoute = $request->route()->getName();

        if (!in_array($curRoute, array_flatten($per))) {
            return Response::view('errors.401', array(), 403);
            //return view('errors.401');
            
        }
        else {
            return $next($request);
        }
        //return $next($request);
    }
};

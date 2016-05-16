<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Request,Response;
class APIAclAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authToken = app('request')->header('X-Auth-Token');
        if (!$authToken) {
            return response('', 401);
        }
        $user = User::where('auth_token',$authToken)->first();
        if(!$user){
            return response('', 401);
        }
        if ($user->auth_token != $authToken) {
            return response('', 401);
        }
        
//        $role = Role::find($user->role_id);
//        $per = $role->permissions()->get(['name'])->toArray();
//        $curRoute = $request->route()->getName();
//        if (!in_array($curRoute, array_flatten($per))) {
//            return Response::view('errors.401', array(), 403);
//            //return view('errors.401');
//            
//        }
        return $next($request);
    }
}

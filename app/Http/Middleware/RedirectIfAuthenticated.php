<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Session;
class RedirectIfAuthenticated
{
    
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;
    
    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($this->auth->check()) {
            if (session('user_type') == 'bank') return redirect('/bank/dashboard');
            if (session('user_type') == 'buyer') return redirect('/buyer/dashboard');
            if (session('user_type') == 'supplier') return redirect('/supplier/dashboard');
        }
        
        return $next($request);
    }
}

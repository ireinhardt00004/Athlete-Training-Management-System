<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Coach
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Define the roles that can be considered as admins
        $allowedRoles = ['coach']; // Add more admin roles if needed
        
        // Check if the user's role is in the allowed roles array
        if (in_array(Auth::user()->roles, $allowedRoles)) {
            return $next($request);
        }
        
        abort(401);
    }
}

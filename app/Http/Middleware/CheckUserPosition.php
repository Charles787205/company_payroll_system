<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserPosition
{
    
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check()) {
            $user = auth()->user();
            $employee = $user->employee;

            if ($employee && strtolower($employee->position->title) == 'admin') { 
                return $next($request);
            } else {
                abort(403, 'Unauthorized');
            }
        }  
        
    }
}

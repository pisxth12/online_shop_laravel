<?php

namespace App\Http\Middleware\Dashboard;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DashboardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
           if(Auth::user()->role == 1){
             return $next($request);
           }else{
            return redirect()->route('category.index')->with('error',"Can't use dashboard");
           }
        }else{
            return redirect()->back()->with('error','cant use dashboard');
        }
    }
}

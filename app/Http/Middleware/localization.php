<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class localization
{
    public function handle($request, Closure $next)
    {
        $locale = Session::get('lang', config('app.lang'));
        App::setLocale($locale);
        return $next($request);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if ($request->hasHeader("Accept-language")){
    //         App::setlocale($request->header("Accept-language"));
    //     }
    //     if (Session::has(('lang'))) 
    //     {
    //        App::setLocale(Session::get(('lang')));
    //     }
    //     return $next($request);
        // if(Session::get("locale") !=null){
        //     App::setLocale(Session::get("locale"));
        // }
        // else{
        //     Session::put("locale","en");
        //     App::setLocale(Session::get("locale"));
        // }
        // return $next($request);
    // }
   
}

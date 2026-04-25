<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Session;

// class LangController extends Controller
// {
//     public function change($lang){
        
//         if ($lang == 'en' || $lang =='fr') {
//             Session::put('lang',$lang);
//             return back();
//         }
//         else return abort(404);
//     }
// }



// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class LangController extends Controller
// {
//     public function changeLanguage($lang)
//     {
//         if (array_key_exists($lang, config('languages'))) {
//             App::setLocale($lang);
//             Session::put('locale', $lang);
//         }
//         return redirect()->back();
//     }
// }


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LangController extends Controller
{
    public function setLang($locale)
    {
        if (array_key_exists($locale, config('languages'))) {
            App::setLocale($locale);
            Session::put("locale", $locale);
             return redirect()->back();
        }
    }
}



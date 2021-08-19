<?php

namespace App\Http\Middleware;

use App\Models\Language as ModelsLanguage;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Language
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
        if(Session::has('locale')) {
            $locale = Session::get('locale');
        } else {
            $lang = ModelsLanguage::where('is_default', 1)->first();
            if ($lang) {
                $locale = $lang->code;
            } else {
                $locale = config('app.locale');
            }
        }

        App::setLocale($locale);
        $request->session()->put('locale', $locale);

        return $next($request);
    }
}

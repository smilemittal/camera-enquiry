<?php

use App\Models\Translation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item => $value) {
        if (($strict ? $item === $needle : $item == $needle) ) {
            return true;
        }
    }

    return false;
}
function translate($key, $lang = null){
    if($lang == null){
        $lang = App::getLocale();
    }

    $translation_def = Translation::where('lang', env('DEFAULT_LANGUAGE', 'en'))->where('lang_key', $key)->first();
    if($translation_def == null){
        $translation_def = new Translation;
        $translation_def->lang = env('DEFAULT_LANGUAGE', 'en');
        $translation_def->lang_key = $key;
        $translation_def->lang_value = $key;
        $translation_def->save();
    }

    //Check for session lang
    $translation_locale = Translation::where('lang_key', $key)->where('lang', $lang)->first();
    if($translation_locale != null){
        return $translation_locale->lang_value;
    }
    else {
        return $translation_def->lang_value;
    }
}
if (! function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset('public/'.$path, $secure);
    }
}

function forgetCachedTranslations(){
    Cache::forget('translations');
}

//highlights the selected navigation on frontend
if (! function_exists('default_language')) {
    function default_language()
    {
        if(!empty(Config::get('theme.default_lang'))) {
            return Config::get('theme.default_lang');
        } else {
           return Config::get('app.locale');
        }
    }
}
<?php

use App\Models\Currency;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

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
    $default_lang = default_language();
    $translation_def = Translation::where('lang', $default_lang)->where('lang_key', $key)->first();
    if($translation_def == null){
        $translation_def = new Translation;
        $translation_def->lang = $default_lang;
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

function forgetCachedTranslations(){
    Cache::forget('translations');
}

//highlights the selected navigation on frontend
if (! function_exists('default_language')) {
    function default_language()
    {
        $lang = Language::where('is_default', 1)->first();
        if ($lang) {
            return $lang->code;
        } else {
           return Config::get('app.locale');
        }
    }
}

//highlights the selected navigation on frontend
if (! function_exists('default_currency')) {
    function default_currency()
    {
        $lang = Currency::where('is_default', 1)->first();
        if ($lang) {
            return $lang->code;
        } else {
           return Config::get('app.default_currency');
        }
    }
}

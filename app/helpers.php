<?php

use Illuminate\Support\Facades\App;

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

<?php

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item => $value) {
        if (($strict ? $item === $needle : $item == $needle) ) {
            return true;
        }
    }

    return false;
}

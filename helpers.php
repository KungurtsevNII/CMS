<?php

function array_get($array, $key, $default = null)
{
    $buf = explode('.', $key);
    foreach ($buf as $key) {
        if (!isset($array[$key])) {
            return $default;
        }
        $array = $array[$key];
    }
    return $array;
}
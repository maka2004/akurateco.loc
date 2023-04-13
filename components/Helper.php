<?php

namespace app\component;

class Helper
{
    /** Check if string contains valid json
     * @param $string
     * @return boolean
     */
    public static function isJson($string)
    {
        @json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}

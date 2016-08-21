<?php

namespace App\Libraries;

class Utilities
{
    public static function makeSnakeCaseRepresentable($str)
    {
        if (is_array($str)) {
            $result = [];
            foreach ($str as $toConvert) {
                $result[$toConvert] = ucfirst(str_replace('_', ' ', $toConvert));
            }
            return $result;
        }
        else
            return ucfirst(str_replace('_', ' ', $str));
    }
}

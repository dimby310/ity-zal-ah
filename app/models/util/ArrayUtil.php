<?php
namespace app\models\util;

class ArrayUtil
{
    public static function arrayToString($array)
    {
        $result = '';
        foreach ($array as $key => $value) {
            $result .= "$key: $value, ";
        }

        return rtrim($result, ', ');
    }
}

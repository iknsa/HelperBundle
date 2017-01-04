<?php
/**
 * Created by iKNSA.
 * Author: Khalid Sookia <khalidsookia@gmail.com>
 * Date: 26/11/16
 * Time: 20:05
 */

namespace IKNSA\HelperBundle\Util;


class Canonicalizer
{
    public static function canonicalize($string)
    {
        if (empty($string)) {
            return null;
        }

        $string = trim($string);

        $encoding = mb_detect_encoding($string);

        $result = $encoding
            ? mb_convert_case($string, MB_CASE_LOWER, $encoding)
            : mb_convert_case($string, MB_CASE_LOWER);

        return $result;
    }
}

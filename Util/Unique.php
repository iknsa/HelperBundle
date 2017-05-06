<?php
/**
 * Created by PhpStorm.
 * User: iknsa
 * Date: 06/05/17
 * Time: 17:25
 */

namespace IKNSA\HelperBundle\Util;


class Unique
{
    /**
     * @param string $prefix
     * @param bool $entropy
     *
     * @return string
     */
    public static function generate($prefix="", $entropy=true)
    {
        return uniqid($prefix . '-', $entropy);
    }
}
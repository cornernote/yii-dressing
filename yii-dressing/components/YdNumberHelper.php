<?php

/**
 * Class YdNumberHelper
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdNumberHelper
{

    /**
     * @param array $array
     * @return bool|float
     */
    public static function getMedian($array = array())
    {
        if (!is_array($array) || empty($array)) return false;
        sort($array);
        $n = count($array);
        if ($n < 1)
            return 0;
        $h = intval($n / 2);
        return ($n % 2 == 0) ? ($array[$h] + $array[$h - 1]) / 2 : $array[$h];
    }

    /**
     * @param array $array
     * @return bool|float
     */
    public static function getAverage($array = array())
    {
        if (!is_array($array) || empty($array)) return false;
        return array_sum($array) / count($array);
    }

    /**
     * @param array $array
     * @return bool|float
     */
    public static function getHigh($array = array())
    {
        if (!is_array($array) || empty($array)) return false;
        return max($array);
    }

    /**
     * @param array $array
     * @return bool|float
     */
    public static function getLow($array = array())
    {
        if (!is_array($array) || empty($array)) return false;
        return min($array);
    }

    /**
     * @link http://www.if-not-true-then-false.com/2010/php-1st-2nd-3rd-4th-5th-6th-php-add-ordinal-number-suffix/
     * @param $num
     * @return string
     */
    public static function addOrdinalNumberSuffix($num)
    {
        if (!in_array(($num % 100), array(11, 12, 13))) {
            switch ($num % 10) {
                case 1:
                    return $num . 'st';
                case 2:
                    return $num . 'nd';
                case 3:
                    return $num . 'rd';
            }
        }
        return $num . 'th';
    }
}
<?php
/**
 * number functions
 */
class YdNumberHelper
{

    /**
     * @param array $array
     * @return bool|float
     */
    static public function getMedian($array = array())
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
    static public function getAverage($array = array())
    {
        if (!is_array($array) || empty($array)) return false;
        return array_sum($array) / count($array);
    }

    /**
     * @param array $array
     * @return bool|float
     */
    static public function getHigh($array = array())
    {
        if (!is_array($array) || empty($array)) return false;
        return max($array);
    }

    /**
     * @param array $array
     * @return bool|float
     */
    static public function getLow($array = array())
    {
        if (!is_array($array) || empty($array)) return false;
        return min($array);
    }
}
<?php

/**
 * YdTimeZone
 */
class YdTimeZone extends CController
{

    /**
     * @param string $timestamp
     * @param null|string $timeZone
     * @return int|null
     */
    public static function strtotime($timestamp, $timeZone = null)
    {
        $offset = $timeZone ? self::offset($timeZone) : 0;
        if (is_numeric($timestamp))
            return $timestamp + $offset;
        return strtotime($timestamp) + $offset;
    }

    /**
     * @param string $timeZone
     * @return int
     */
    public static function offset($timeZone)
    {
        if (!$timeZone || $timeZone == 'GMT') return 0;
        $dateTimeZone = new DateTimeZone($timeZone);
        $dateTime = new DateTime('now', $dateTimeZone);
        return $dateTimeZone->getOffset($dateTime);
    }

}
<?php

/**
 * YdDateHelper
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdDateHelper
{

    /**
     * @param $timestamp
     * @return int|null
     */
    public static function timestamp($timestamp)
    {
        if (!$timestamp)
            return null;
        if (is_numeric($timestamp))
            return $timestamp;
        return strtotime($timestamp);
    }

    /**
     * @static
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    public static function differenceInDays($startDate, $endDate)
    {
        return round((self::strtotime($endDate) - self::strtotime($startDate)) / (60 * 60 * 24));
    }

    /**
     * The function returns the no. of business days between two dates
     *
     * @param string $startDate
     * @param string $endDate
     * @param array $holidays
     * @return int
     */
    public static function differenceInWeekDays($startDate, $endDate, $holidays = array())
    {
        // do strtotime calculations just once
        $endDate = strtotime($endDate);
        $startDate = strtotime($startDate);


        //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
        //We add one to inlude both dates in the interval.
        $days = ($endDate - $startDate) / 86400 + 1;

        $no_full_weeks = floor($days / 7);
        $no_remaining_days = fmod($days, 7);

        //It will return 1 if it's Monday,.. ,7 for Sunday
        $the_first_day_of_week = date("N", $startDate);
        $the_last_day_of_week = date("N", $endDate);

        //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
        //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
        if ($the_first_day_of_week <= $the_last_day_of_week) {
            if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week)
                $no_remaining_days--;
            if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week)
                $no_remaining_days--;
        }
        else {
            // (edit by Tokes to fix an edge case where the start day was a Sunday
            // and the end day was NOT a Saturday)

            // the day of the week for start is later than the day of the week for end
            if ($the_first_day_of_week == 7) {
                // if the start date is a Sunday, then we definitely subtract 1 day
                $no_remaining_days--;

                if ($the_last_day_of_week == 6) {
                    // if the end date is a Saturday, then we subtract another day
                    $no_remaining_days--;
                }
            }
            else {
                // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
                // so we skip an entire weekend and subtract 2 days
                $no_remaining_days -= 2;
            }
        }

        //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
        //---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
        $workingDays = $no_full_weeks * 5;
        if ($no_remaining_days > 0) {
            $workingDays += $no_remaining_days;
        }

        //We subtract the holidays
        foreach ($holidays as $holiday) {
            $time_stamp = strtotime($holiday);
            //If the holiday doesn't fall in weekend
            if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7)
                $workingDays--;
        }

        return $workingDays;
    }

    /**
     * Returns true if given date is today.
     *
     * @param string $timestamp
     * @return boolean True if date is today
     */
    public static function isToday($timestamp)
    {
        $timestamp = self::timestamp($timestamp);
        return date('Y-m-d', $timestamp) == date('Y-m-d', time());
    }

    /**
     * Returns true if given date was yesterday
     *
     * @param string $timestamp
     * @return boolean True if date was yesterday
     */
    public static function isYesterday($timestamp)
    {
        $timestamp = self::timestamp($timestamp);
        return date('Y-m-d', $timestamp) == date('Y-m-d', strtotime('yesterday'));
    }

    /**
     * Returns true if given date is in this year
     *
     * @param string $timestamp
     * @return boolean True if date is in this year
     */
    public static function isThisYear($timestamp)
    {
        $timestamp = self::timestamp($timestamp);
        return date('Y', $timestamp) == date('Y', time());
    }

    /**
     * Returns true if given date is in this week
     *
     * @param string $timestamp
     * @return boolean True if date is in this week
     */
    public static function isThisWeek($timestamp)
    {
        $timestamp = self::timestamp($timestamp);
        return date('W Y', $date) == date('W Y', time());
    }

    /**
     * Returns true if given date is in this month
     *
     * @param string $timestamp
     * @return boolean True if date is in this month
     */
    public static function isThisMonth($timestamp)
    {
        $timestamp = self::timestamp($timestamp);
        return date('m Y', $timestamp) == date('m Y', time());
    }

}
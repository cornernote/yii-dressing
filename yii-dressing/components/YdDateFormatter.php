<?php

/**
 * YdDateFormatter
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdDateFormatter extends CDateFormatter
{

    /**
     * @param $timestamp
     * @return int|null
     */
    public function timestamp($timestamp)
    {
        if (!$timestamp)
            return null;
        if (is_numeric($timestamp))
            return $timestamp;
        return strtotime($timestamp);
    }

    /**
     * The function returns the no. of business days between two dates
     *
     * @param string $startDate
     * @param string $endDate
     * @param array $holidays
     * @return float|int
     */
    public function getWorkingDays($startDate, $endDate, $holidays)
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
    public function isToday($timestamp)
    {
        $timestamp = $this->timestamp($timestamp);
        return date('Y-m-d', $timestamp) == date('Y-m-d', time());
    }

    /**
     * Returns true if given date was yesterday
     *
     * @param string $timestamp
     * @return boolean True if date was yesterday
     */
    public function isYesterday($timestamp)
    {
        $timestamp = $this->timestamp($timestamp);
        return date('Y-m-d', $timestamp) == date('Y-m-d', strtotime('yesterday'));
    }

    /**
     * Returns true if given date is in this year
     *
     * @param string $timestamp
     * @return boolean True if date is in this year
     */
    public function isThisYear($timestamp)
    {
        $timestamp = $this->timestamp($timestamp);
        return date('Y', $timestamp) == date('Y', time());
    }

    /**
     * Returns true if given date is in this week
     *
     * @param string $timestamp
     * @return boolean True if date is in this week
     */
    public function isThisWeek($timestamp)
    {
        $timestamp = $this->timestamp($timestamp);
        return date('W Y', $date) == date('W Y', time());
    }

    /**
     * Returns true if given date is in this month
     *
     * @param string $timestamp
     * @return boolean True if date is in this month
     */
    public function isThisMonth($timestamp)
    {
        $timestamp = $this->timestamp($timestamp);
        return date('m Y', $timestamp) == date('m Y', time());
    }

    /**
     * @param $timestamp
     * @param string $format
     * @return bool|string
     */
    public function formatTimeAgoIcon($timestamp, $dateWidth = 'medium', $timeWidth = 'medium')
    {
        return CHtml::link('<i class="icon-time"></i>', 'javascript:void();', array('title' => $this->formatAgo($timestamp))) . '&nbsp;' . $this->formatDateTime($timestamp, $dateWidth, $timeWidth);
    }

    /**
     * @param $timestamp
     * @param int $rcs
     * @param null $_ago
     * @return string
     */
    public function formatTimeAgo($timestamp, $rcs = 0, $_ago = null)
    {
        $tm = $this->timestamp($timestamp);
        if (!$tm) {
            return '';
        }
        $cur_tm = time();
        $dif = $cur_tm - $tm;
        if ($cur_tm < $tm) {
            $dif = $dif * -1;
            $_ago = 'away';
        }
        $pds = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade');
        $l = array(1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600);
        $no = 0;
        for ($v = sizeof($l) - 1; ($v >= 0) && (($no = $dif / $l[$v]) <= 1); $v--)
            ;
        if ($v < 0)
            $v = 0;
        $_tm = $cur_tm - ($dif % $l[$v]);
        $no = floor($no);
        if ($no <> 1)
            $pds[$v] .= 's';
        $x = sprintf("%d %s ", $no, $pds[$v]);
        if (($rcs == 1) && ($v >= 1) && (($cur_tm - $_tm) > 0))
            $x .= $this->ago($_tm, 0, $_ago);
        $ago = '';
        if (!$rcs) {
            if (isset($_ago))
                $ago = ' ' . $_ago;
            else
                $ago = ' ago';
        }
        return $x . $ago;
    }

}
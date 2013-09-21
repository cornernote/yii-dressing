<?php
/**
 *
 */
class YdTime
{

    /**
     * @param $dtGiven
     * @return int|null
     */
    public static function timestamp($dtGiven)
    {
        if (!$dtGiven)
            return null;
        if (is_numeric($dtGiven))
            return $dtGiven;
        return strtotime($dtGiven);
    }

    /**
     * @param $dtGiven
     * @param string $format
     * @return null|string
     */
    public static function date($dtGiven, $format = 'Y-m-d')
    {
        $date = self::timestamp($dtGiven);
        return date($format, $date);
    }

    /**
     * @param $dtGiven
     * @param string $format
     * @return null|string
     */
    public static function datetime($dtGiven, $format = 'Y-m-d H:i:s')
    {
        if (!$dtGiven)
            return null;
        $date = self::timestamp($dtGiven);
        return date($format, $date);
    }

    /**
     * Returns a nicely formatted date string for given Datetime string.
     *
     * @param string $dtGiven
     * @param int|string $format Format of returned date
     * @return string Formatted date string
     */
    public static function nice($dtGiven = null, $format = 'dateTimeFormat')
    {
        $date = self::timestamp($dtGiven);
        if (!$date) {
            return '';
        }
        $paramFormat = Yii::app()->params[$format];
        if (!$paramFormat) {
            $paramFormat = Yii::app()->params['dateTimeFormat'];
        }
        return date($paramFormat, $date);
    }

    /**
     * @static
     * @param $dtGiven
     * @param $strToTimeString
     * @param string $dtFormat
     * @return string
     */
    public static function getRelativeDate($dtGiven, $strToTimeString, $dtFormat = 'Y-m-d')
    {
        //use like Time::getRelativeDate('01-Jan-1990', '+2 days')
        $stamp = self::timestamp($dtGiven);
        $relativeDateStamp = strtotime($strToTimeString, $stamp);
        $relativeDate = date($dtFormat, $relativeDateStamp);
        return $relativeDate;
    }

    /**
     * @static
     * @param string $date1 bigger date value
     * @param string $date2 smaller date value
     * @param bool $round
     * @param bool|array $holidays
     * @return int
     */
    public static function differentInDays($date1, $date2, $round = true, $holidays = false)
    {
        $diff = strtotime($date1) - strtotime($date2);
        $diff = $diff / (60 * 60 * 24);

        if (($diff > 1) && is_array($holidays)) {
            if (current($holidays) == 'victoria') {
                $holidays = self::getVictoriaHolidays();
            }
            $diff = self::getWorkingDays($date2, $date1, $holidays) - 1;
        }
        if ($round) {
            $diff = round($diff);
        }
        return $diff;
    }

    public static function getVictoriaHolidays()
    {
        return array(
            '1-January-2010',
            '26-January-2010',
            '8-March-2010',
            '2-April-2010',
            '3-April-2010',
            '5-April-2010',
            '25-April-2010',
            '14-June-2010',
            '2-November-2010',
            '25-December-2010',
            '26-December-2010',
            '1-January-2011',
            '26-January-2011',
            '14-March-2011',
            '22-April-2011',
            '23-April-2011',
            '25-April-2011',
            '26-April-2011',
            '13-June-2011',
            '1-November-2011',
            '27-December-2011',
            '26-Decembe-2011',
            '1-January-2012',
            '26-January-2012',
            '12-March-2012',
            '6-April-2012',
            '7-April-2012',
            '9-April-2012',
            '25-April-2012',
            '11-June-2012',
            '6-November-2012',
            '25-December-2012',
            '1-January-2013',
            '26-January-2013',
            '11-March-2013',
            '29-March-2013',
            '30-March-2013',
            '1-April-2013',
            '25-April-2013',
            '10-June-2013',
            '5-November-2013',
            '25-December-2013',
        );
    }

    /**
     *
     * The function returns the no. of business days between two dates and it skips the holidays
     *
     * @static
     * @param string $startDate
     * @param string $endDate
     * @param array $holidays
     * @return float|int
     */
    public static function getWorkingDays($startDate, $endDate, $holidays)
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
     * Returns a formatted descriptive date string for given datetime string.
     *
     * If the given date is today, the returned string could be "Today, 6:54 pm".
     * If the given date was yesterday, the returned string could be "Yesterday, 6:54 pm".
     * If $dtGiven's year is the current year, the returned string does not
     * include mention of the year.
     *
     * @param string $dtGiven
     * @return string Described, relative date string
     */
    public static function short($dtGiven = null)
    {
        $date = ($dtGiven == null) ? time() : self::timestamp($dtGiven);

        $y = (self::isThisYear($date)) ? '' : ' Y';

        if (self::isToday($date)) {
            $ret = sprintf('Today, %s', date("g:i a", $date));
        }
        elseif (self::wasYesterday($date)) {
            $ret = sprintf('Yesterday, %s', date("g:i a", $date));
        }
        else {
            $ret = date("M jS{$y}, H:i", $date);
        }

        return $ret;
    }

    /**
     * Returns true if given date is today.
     *
     * @param string $dtGiven
     * @return boolean True if date is today
     */
    public static function isToday($dtGiven)
    {
        $date = self::timestamp($dtGiven);
        return date('Y-m-d', $date) == date('Y-m-d', time());
    }

    /**
     * Returns true if given date was yesterday
     *
     * @param string $dtGiven
     * @return boolean True if date was yesterday
     */
    public static function wasYesterday($dtGiven)
    {
        $date = self::timestamp($dtGiven);
        return date('Y-m-d', $date) == date('Y-m-d', strtotime('yesterday'));
    }

    /**
     * Returns true if given date is in this year
     *
     * @param string $dtGiven
     * @return boolean True if date is in this year
     */
    public static function isThisYear($dtGiven)
    {
        $date = self::timestamp($dtGiven);
        return date('Y', $date) == date('Y', time());
    }

    /**
     * Returns true if given date is in this week
     *
     * @param string $dtGiven
     * @return boolean True if date is in this week
     */
    public static function isThisWeek($dtGiven)
    {
        $date = self::timestamp($dtGiven);
        return date('W Y', $date) == date('W Y', time());
    }

    /**
     * Returns true if given date is in this month
     *
     * @param string $dtGiven
     * @return boolean True if date is in this month
     */
    public static function isThisMonth($dtGiven)
    {
        $date = self::timestamp($dtGiven);
        return date('m Y', $date) == date('m Y', time());
    }

    /**
     * @param $dtGiven
     * @param string $format
     * @return bool|string
     */
    public static function agoIcon($dtGiven, $format = 'd-M-Y H:i:s')
    {
        if (!$dtGiven) {
            return false;
        }
        $dtStamp = self::timestamp($dtGiven);
        $ago = self::ago($dtStamp);
        $date = date($format, $dtStamp);
        $icon = CHtml::link('<i class="icon-time"></i>', 'javascript:void();', array('title' => $date));
        $agoWithIcon = $icon . '&nbsp;' . $ago;
        return $agoWithIcon;
    }

    /**
     * @param $gmDateGiven string
     * @return string
     */
    public static function gmDateToDate($gmDateGiven)
    {
        $format = 'Y-m-d H:i:s';
        $gmDate = gmdate($format);
        $date = date($format);
        $diff = strtotime($date) - strtotime($gmDate);

        $time = strtotime($gmDateGiven);
        $time += 10 + $diff;

        date($format, $time);
        return $date;

    }

    /**
     * @static
     * @param $dtGiven
     * @param int $rcs
     * @param null $_ago
     * @return string
     */
    public static function ago($dtGiven, $rcs = 0, $_ago = null)
    {
        $tm = self::timestamp($dtGiven);
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
            $x .= self::ago($_tm, 0, $_ago);
        $ago = '';
        if (!$rcs) {
            if (isset($_ago))
                $ago = ' ' . $_ago;
            else
                $ago = ' ago';
        }
        return $x . $ago;
    }

    /**
     * Returns either a relative date or a formatted date depending
     * on the difference between the current time and given datetime.
     * $datetime should be in a <i>strtotime</i>-parsable format, like MySQL's datetime datatype.
     *
     * Options:
     *  'format' => a fall back format if the relative time is longer than the duration specified by end
     *  'end' =>  The end of relative time telling
     *
     * Relative dates look something like this:
     *    3 weeks, 4 days ago
     *    15 seconds ago
     * Formatted dates look like this:
     *    on 02/18/2004
     *
     * The returned string includes 'ago' or 'on' and assumes you'll properly add a word
     * like 'Posted ' before the function output.
     *
     * @param $dtGiven
     * @param array $options Default format if timestamp is used in $dateString
     * @internal param string $dateString Datetime string
     * @return string Relative time string.
     */
    public static function timeAgoInWords($dtGiven, $options = array())
    {
        $dateTime = self::timestamp($dtGiven);
        $now = time();

        $inSeconds = strtotime($dateTime);
        $backwards = ($inSeconds > $now);

        $format = 'j/n/y';
        $end = '+1 month';

        if (is_array($options)) {
            if (isset($options['format'])) {
                $format = $options['format'];
                unset($options['format']);
            }
            if (isset($options['end'])) {
                $end = $options['end'];
                unset($options['end']);
            }
        }
        else {
            $format = $options;
        }

        if ($backwards) {
            $futureTime = $inSeconds;
            $pastTime = $now;
        }
        else {
            $futureTime = $now;
            $pastTime = $inSeconds;
        }
        $diff = $futureTime - $pastTime;

        // If more than a week, then take into account the length of months
        if ($diff >= 604800) {
            $current = array();
            $date = array();

            list($future['H'], $future['i'], $future['s'], $future['d'], $future['m'], $future['Y']) = explode('/', date('H/i/s/d/m/Y', $futureTime));

            list($past['H'], $past['i'], $past['s'], $past['d'], $past['m'], $past['Y']) = explode('/', date('H/i/s/d/m/Y', $pastTime));
            $years = $months = $weeks = $days = $hours = $minutes = $seconds = 0;

            if ($future['Y'] == $past['Y'] && $future['m'] == $past['m']) {
                $months = 0;
                $years = 0;
            }
            else {
                if ($future['Y'] == $past['Y']) {
                    $months = $future['m'] - $past['m'];
                }
                else {
                    $years = $future['Y'] - $past['Y'];
                    $months = $future['m'] + ((12 * $years) - $past['m']);

                    if ($months >= 12) {
                        $years = floor($months / 12);
                        $months = $months - ($years * 12);
                    }

                    if ($future['m'] < $past['m'] && $future['Y'] - $past['Y'] == 1) {
                        $years--;
                    }
                }
            }

            if ($future['d'] >= $past['d']) {
                $days = $future['d'] - $past['d'];
            }
            else {
                $daysInPastMonth = date('t', $pastTime);
                $daysInFutureMonth = date('t', mktime(0, 0, 0, $future['m'] - 1, 1, $future['Y']));

                if (!$backwards) {
                    $days = ($daysInPastMonth - $past['d']) + $future['d'];
                }
                else {
                    $days = ($daysInFutureMonth - $past['d']) + $future['d'];
                }

                if ($future['m'] != $past['m']) {
                    $months--;
                }
            }

            if ($months == 0 && $years >= 1 && $diff < ($years * 31536000)) {
                $months = 11;
                $years--;
            }

            if ($months >= 12) {
                $years = $years + 1;
                $months = $months - 12;
            }

            if ($days >= 7) {
                $weeks = floor($days / 7);
                $days = $days - ($weeks * 7);
            }
        }
        else {
            $years = $months = $weeks = 0;
            $days = floor($diff / 86400);

            $diff = $diff - ($days * 86400);

            $hours = floor($diff / 3600);
            $diff = $diff - ($hours * 3600);

            $minutes = floor($diff / 60);
            $diff = $diff - ($minutes * 60);
            $seconds = $diff;
        }
        $relativeDate = '';
        $diff = $futureTime - $pastTime;

        if ($diff > abs($now - strtotime($end))) {
            $relativeDate = sprintf('on %s', date($format, $inSeconds));
        }
        else {
            if ($years > 0) {
                // years and months and days
                $relativeDate .= ($relativeDate ? ', ' : '') . $years . ' ' . ($years == 1 ? 'year' : 'years');
                $relativeDate .= $months > 0 ? ($relativeDate ? ', ' : '') . $months . ' ' . ($months == 1 ? 'month' : 'months') : '';
                $relativeDate .= $weeks > 0 ? ($relativeDate ? ', ' : '') . $weeks . ' ' . ($weeks == 1 ? 'week' : 'weeks') : '';
                $relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . ($days == 1 ? 'day' : 'days') : '';
            }
            elseif (abs($months) > 0) {
                // months, weeks and days
                $relativeDate .= ($relativeDate ? ', ' : '') . $months . ' ' . ($months == 1 ? 'month' : 'months');
                $relativeDate .= $weeks > 0 ? ($relativeDate ? ', ' : '') . $weeks . ' ' . ($weeks == 1 ? 'week' : 'weeks') : '';
                $relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . ($days == 1 ? 'day' : 'days') : '';
            }
            elseif (abs($weeks) > 0) {
                // weeks and days
                $relativeDate .= ($relativeDate ? ', ' : '') . $weeks . ' ' . ($weeks == 1 ? 'week' : 'weeks');
                $relativeDate .= $days > 0 ? ($relativeDate ? ', ' : '') . $days . ' ' . ($days == 1 ? 'day' : 'days') : '';
            }
            elseif (abs($days) > 0) {
                // days and hours
                $relativeDate .= ($relativeDate ? ', ' : '') . $days . ' ' . ($days == 1 ? 'day' : 'days');
                $relativeDate .= $hours > 0 ? ($relativeDate ? ', ' : '') . $hours . ' ' . ($hours == 1 ? 'hour' : 'hours') : '';
            }
            elseif (abs($hours) > 0) {
                // hours and minutes
                $relativeDate .= ($relativeDate ? ', ' : '') . $hours . ' ' . ($hours == 1 ? 'hour' : 'hours');
                $relativeDate .= $minutes > 0 ? ($relativeDate ? ', ' : '') . $minutes . ' ' . ($minutes == 1 ? 'minute' : 'minutes') : '';
            }
            elseif (abs($minutes) > 0) {
                // minutes only
                $relativeDate .= ($relativeDate ? ', ' : '') . $minutes . ' ' . ($minutes == 1 ? 'minute' : 'minutes');
            }
            else {
                // seconds only
                $relativeDate .= ($relativeDate ? ', ' : '') . $seconds . ' ' . ($seconds == 1 ? 'second' : 'seconds');
            }

            if (!$backwards) {
                $relativeDate = sprintf('%s ago', $relativeDate);
            }
        }
        return $relativeDate;
    }

}
<?php

/**
 * YdDeviceDetection
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @copyright 2014 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdDeviceDetection extends CApplicationComponent
{

    /**
     * @var string
     */
    public $deviceString = 'device';

    /**
     * @var string
     */
    public $deviceTv = 'tv';

    /**
     * @var string
     */
    public $deviceTablet = 'tablet';

    /**
     * @var string
     */
    public $deviceMobile = 'mobile';

    /**
     * @var string
     */
    public $deviceDesktop = 'desktop';

    /**
     * @var string
     */
    private $_device;

    /**
     * @return string
     */
    public function init()
    {
        if (!empty($_GET[$this->deviceString]) && in_array($_GET[$this->deviceString], array('desktop', 'tablet', 'tv', 'mobile'))) {
            $_SESSION[$this->deviceString] = $_GET[$this->deviceString];
            $this->setDevice($_GET[$this->deviceString]);
        }
        elseif (!empty($_SESSION[$this->deviceString])) {
            $this->setDevice($_SESSION[$this->deviceString]);
        }
    }

    /**
     * @param string $device
     */
    public function setDevice($device)
    {
        $this->_device = $device;
    }

    /**
     * @author Brett Jankord - Copyright © 2011 http://www.brettjankord.com/2012/01/16/categorizr-a-modern-device-detection-script/
     * @license GPL3
     * @return string
     */
    public function getDevice()
    {
        if ($this->_device) {
            return $this->_device;
        }
        $ua = $_SERVER['HTTP_USER_AGENT'];

        // Smart TV - http://goo.gl/FocDk
        if ((preg_match('/GoogleTV|SmartTV|Internet.TV|NetCast|NETTV|AppleTV|boxee|Kylo|Roku|DLNADOC|CE\-HTML/i', $ua))) {
            return $this->_device = $this->deviceTv;
        }
        // TV Based Gaming Console
        if ((preg_match('/Xbox|PLAYSTATION.3|Wii/i', $ua))) {
            return $this->_device = $this->deviceTv;
        }
        // Tablet
        if ((preg_match('/iP(a|ro)d/i', $ua)) || (preg_match('/tablet/i', $ua)) && (!preg_match('/RX-34/i', $ua)) || (preg_match('/FOLIO/i', $ua))) {
            return $this->_device = $this->deviceTablet;
        }
        // Android Tablet
        if ((preg_match('/Linux/i', $ua)) && (preg_match('/Android/i', $ua)) && (!preg_match('/Fennec|mobi|HTC.Magic|HTCX06HT|Nexus.One|SC-02B|fone.945/i', $ua))) {
            return $this->_device = $this->deviceTablet;
        }
        // Kindle or Kindle Fire
        if ((preg_match('/Kindle/i', $ua)) || (preg_match('/Mac.OS/i', $ua)) && (preg_match('/Silk/i', $ua))) {
            return $this->_device = $this->deviceTablet;
        }
        // Pre Android 3.0 Tablet
        if ((preg_match('/GT-P10|SC-01C|SHW-M180S|SGH-T849|SCH-I800|SHW-M180L|SPH-P100|SGH-I987|zt180|HTC(.Flyer|\_Flyer)|Sprint.ATP51|ViewPad7|pandigital(sprnova|nova)|Ideos.S7|Dell.Streak.7|Advent.Vega|A101IT|A70BHT|MID7015|Next2|nook/i', $ua)) || (preg_match('/MB511/i', $ua)) && (preg_match('/RUTEM/i', $ua))) {
            return $this->_device = $this->deviceTablet;
        }
        // Unique Mobile User Agent
        if ((preg_match('/BOLT|Fennec|Iris|Maemo|Minimo|Mobi|mowser|NetFront|Novarra|Prism|RX-34|Skyfire|Tear|XV6875|XV6975|Google.Wireless.Transcoder/i', $ua))) {
            return $this->_device = $this->deviceMobile;
        }
        // Odd Opera User Agent - http://goo.gl/nK90K
        if ((preg_match('/Opera/i', $ua)) && (preg_match('/Windows.NT.5/i', $ua)) && (preg_match('/HTC|Xda|Mini|Vario|SAMSUNG\-GT\-i8000|SAMSUNG\-SGH\-i9/i', $ua))) {
            return $this->_device = $this->deviceMobile;
        }
        // Windows Desktop
        if ((preg_match('/Windows.(NT|XP|ME|9)/', $ua)) && (!preg_match('/Phone/i', $ua)) || (preg_match('/Win(9|.9|NT)/i', $ua))) {
            return $this->_device = $this->deviceDesktop;
        }
        // Mac Desktop
        if ((preg_match('/Macintosh|PowerPC/i', $ua)) && (!preg_match('/Silk/i', $ua))) {
            return $this->_device = $this->deviceDesktop;
        }
        // Linux Desktop
        if ((preg_match('/Linux/i', $ua)) && (preg_match('/X11/i', $ua))) {
            return $this->_device = $this->deviceDesktop;
        }
        // Solaris, SunOS, BSD Desktop
        if ((preg_match('/Solaris|SunOS|BSD/i', $ua))) {
            return $this->_device = $this->deviceDesktop;
        }
        // Desktop BOT/Crawler/Spider
        if ((preg_match('/Bot|Crawler|Spider|Yahoo|ia_archiver|Covario-IDS|findlinks|DataparkSearch|larbin|Mediapartners-Google|NG-Search|Snappy|Teoma|Jeeves|TinEye/i', $ua)) && (!preg_match('/Mobile/i', $ua))) {
            return $this->_device = $this->deviceDesktop;
        }
        // Assume it is a Mobile Device
        return $this->_device = $this->deviceMobile;
    }

    /**
     * @author Adaptive images http://adaptive-images.com
     * @license Adaptive Images by Matt Wilcox is licensed under a Creative Commons Attribution 3.0 Unported License.
     */
    public function getResolution()
    {
        $resolutions = array(1382, 992, 768, 480); // the resolution break-points to use (screen widths, in pixels)
        $resolution = false;

        if (isset($_COOKIE['resolution'])) {
            $cookie_value = $_COOKIE['resolution'];

            // does the cookie look valid? [whole number, comma, potential floating number]
            if (!preg_match('/^[0-9]+[,]*[0-9\.]+$/', $cookie_value)) { // no it doesn't look valid
                setcookie('resolution', $cookie_value, time() - 100); // delete the mangled cookie
            }
            // the cookie is valid, do stuff with it
            else {
                $cookie_data = explode(',', $_COOKIE['resolution']);
                $client_width = (int)$cookie_data[0]; // the base resolution (CSS pixels)
                $total_width = $client_width;
                $pixel_density = 1; // set a default, used for non-retina style JS snippet
                if (isset($cookie_data[1])) { // the device's pixel density factor (physical pixels per CSS pixel)
                    $pixel_density = $cookie_data[1];
                }

                rsort($resolutions); // make sure the supplied break-points are in reverse size order
                $resolution = $resolutions[0]; // by default use the largest supported break-point

                // if pixel density is not 1, then we need to be smart about adapting and fitting into the defined breakpoints
                if ($pixel_density != 1) {
                    $total_width = $client_width * $pixel_density; // required physical pixel width of the image

                    // the required image width is bigger than any existing value in $resolutions
                    if ($total_width > $resolutions[0]) {
                        // firstly, fit the CSS size into a break point ignoring the multiplier
                        foreach ($resolutions as $break_point) { // filter down
                            if ($total_width <= $break_point) {
                                $resolution = $break_point;
                            }
                        }
                        // now apply the multiplier
                        $resolution = $resolution * $pixel_density;
                    }
                    // the required image fits into the existing breakpoints in $resolutions
                    else {
                        foreach ($resolutions as $break_point) { // filter down
                            if ($total_width <= $break_point) {
                                $resolution = $break_point;
                            }
                        }
                    }
                }
                else { // pixel density is 1, just fit it into one of the breakpoints
                    foreach ($resolutions as $break_point) { // filter down
                        if ($total_width <= $break_point) {
                            $resolution = $break_point;
                        }
                    }
                }
            }
        }

        /* No resolution was found (no cookie or invalid cookie) */
        if (!$resolution) {
            // We send the lowest resolution for mobile-first approach, and highest otherwise
            $resolution = $this->isMobile() ? min($resolutions) : max($resolutions);
        }
        return $resolution;
    }

    /**
     * @return bool
     */
    public function isDesktop()
    {
        return $this->getDevice() == 'desktop';
    }

    /**
     * @return bool
     */
    public function isTablet()
    {
        return $this->getDevice() == 'tablet';
    }

    /**
     * @return bool
     */
    public function isTV()
    {
        return $this->getDevice() == 'tv';
    }

    /**
     * @return bool
     */
    public function isMobile()
    {
        return $this->getDevice() == 'mobile';
    }
}

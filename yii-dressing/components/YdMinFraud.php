<?php

/**
 * YdMinFraud
 *
 * @link https://minfraud.maxmind.com/app/ccv
 *
 * Usage:
 * Yii::app()->minFraud->getMinFraud(array(
 *     'license_key' => 'YOUR_LICENSE_KEY_HERE',
 *     'i' => '24.24.24.24',
 *     'domain' => 'yahoo.com',
 *     'city' => 'New+York',
 *     'region' => 'NY',
 *     'postal' => '10011',
 *     'country' => 'US',
 *     'bin' => '549099'
 * ));
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdMinFraud extends CApplicationComponent
{

    /**
     * @var string
     */
    public $licenseKey;

    /**
     * @param $options
     * @return array
     */
    public function getMinFraud($options)
    {
        $options['license_key'] = $this->licenseKey;
        $minfraud = array();
        YdCurl::$followLocation = 0;
        $minfraud_contents = YdCurl::download('https://minfraud.maxmind.com/app/ccv2r?' . http_build_query($options));
        YdCurl::$followLocation = 1;
        if ($minfraud_contents) {
            $minfraud_array = explode(';', $minfraud_contents);
            foreach ($minfraud_array as $minfraud_row) {
                list($key, $val) = explode('=', $minfraud_row);
                $minfraud[$key] = $val;
            }
        }
        return $minfraud;
    }

}

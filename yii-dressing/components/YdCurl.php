<?php

/**
 * YdCurl
 *
 * @package dressing.components
 */
class YdCurl
{

    /**
     * @var string
     */
    public static $agent;

    /**
     * @var string
     */
    public static $referer;

    /**
     * @var string
     */
    public static $basicAuth;

    /**
     * @var int
     */
    public static $timeout = 30;

    /**
     * @var int
     */
    public static $validStatus = 200;

    /**
     * @var bool
     */
    public static $followLocation = true;

    /**
     * @param string $url
     * @param string|array $post
     * @return bool|string
     */
    static public function download($url, $post = array())
    {
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, is_string($post) ? $post : http_build_query($post));
        }
        if (self::$basicAuth) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_USERPWD, self::$basicAuth);
        }
        if (self::$followLocation) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        }
        if (self::$referer) {
            curl_setopt($ch, CURLOPT_REFERER, self::$referer);
        }
        if (self::$agent) {
            curl_setopt($ch, CURLOPT_USERAGENT, self::$agent);
        }
        if (self::$timeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);
        }
        $_url = parse_url($url);
        $cookieFile = Yii::app()->getRuntimePath() . '/cookies/' . md5($_url['host']);
        if (!file_exists(dirname($cookieFile)))
            mkdir($cookieFile, 0755, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        $output = curl_exec($ch);
        //debug(curl_getinfo($ch));
        if (self::$validStatus) {
            return curl_getinfo($ch, CURLINFO_HTTP_CODE) == self::$validStatus ? $output : false;
        }
        curl_close($ch);
        return $output;
    }

}
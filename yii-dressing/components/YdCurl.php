<?php

/**
 * YdCurl
 *
 * @package dressing.components
 */
class YdCurl
{

    /**
     * @param string $url
     * @param string|array $post
     * @param null|string $referer
     * @return bool|string
     */
    static public function download($url, $post = array(), $referer = null)
    {
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, self::$agent);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, is_string($post) ? $post : http_build_query($post));
        }
        if ($referer) {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
        $_url = parse_url($url);
        $cookieFile = Yii::app()->getRuntimePath() . '/cookies/' . md5($_url['host']);
        if (!file_exists(dirname($cookieFile)))
            mkdir($cookieFile, 0755, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        $output = curl_exec($ch);
        return curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200' ? $output : false;
    }

}
<?php

/**
 * Class YdUrlReader
 *
 * @package dressing.components
 */
class YdUrlReader
{
    /**
     * @param $url
     * @param null $referer
     * @param bool $follow
     * @param bool $return
     * @return bool|mixed
     */
    public static function getUrl($url, $referer = null, $follow = true, $return = true)
    {
        if (!file_exists(Yii::app()->getRuntimePath() . '/cookies')) {
            mkdir(Yii::app()->getRuntimePath() . '/cookies');
        }

        $_url = parse_url($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_COOKIEFILE, Yii::app()->getRuntimePath() . '/cookies/' . DS . md5($_url['host']));
        //curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
        if ($follow) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        }
        if ($referer) {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
        $data = false;
        if ($return) {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != '200') {
                $data = '';
            }
        }
        else {
            curl_exec($ch);
        }
        curl_close($ch);
        if ($return) {
            return $data;
        }
    }

    /**
     * @param $url
     * @param $params
     * @return mixed
     */
    public static function postUrl($url, $params)
    {
        if (!file_exists(Yii::app()->getRuntimePath() . '/cookies')) {
            mkdir(Yii::app()->getRuntimePath() . '/cookies');
        }

        $_url = parse_url($url);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_COOKIEJAR, Yii::app()->getRuntimePath() . '/cookies/' . md5($_url['host']));
        curl_setopt($ch, CURLOPT_COOKIEFILE, Yii::app()->getRuntimePath() . '/cookies/' . md5($_url['host']));

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, is_string($params) ? $params : http_build_query($params));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);

        curl_setopt($ch, CURLOPT_FAILONERROR, 0);
        //curl_setopt($ch, CURLOPT_VERBOSE, TRUE);

        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * @param $array
     * @return string
     */
    public static function preparePostFields($array)
    {
        if (!is_array($array)) return $array;
        $params = array();
        foreach ($array as $key => $value) {
            $params[] = $key . '=' . urlencode($value);
        }
        return implode('&', $params);
    }

}
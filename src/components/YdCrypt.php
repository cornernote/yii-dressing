<?php
/**
 * Class YdCrypt
 */
class YdCrypt
{

    /**
     * @var string
     */
    static private $key = 'r_$&m|5&;/;gH}N';

    /**
     * @param string $decrypted
     * @param bool $lowSecurity
     * @return string
     */
    static public function encrypt($decrypted, $lowSecurity = false)
    {
        $key = self::getKey();
        if ($lowSecurity)
            return self::safe_base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $decrypted, MCRYPT_MODE_CBC, md5(md5($key))));
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $plain_utf8 = utf8_encode($decrypted);
        $cipher = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plain_utf8, MCRYPT_MODE_CBC, $iv);
        return self::safe_base64_encode($iv . $cipher);
    }

    /**
     * @param string $encrypted
     * @param bool $lowSecurity
     * @return string
     */
    static public function decrypt($encrypted, $lowSecurity = false)
    {
        $key = self::getKey();
        if ($lowSecurity)
            return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), self::safe_base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $cipher = self::safe_base64_decode($encrypted);
        $iv = substr($cipher, 0, $iv_size);
        $cipher = substr($cipher, $iv_size);
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $cipher, MCRYPT_MODE_CBC, $iv));
    }

    /**
     * @return string
     */
    static private function getKey()
    {
        return pack('H*', md5(date('Ymd') . self::$key));
    }

    /**
     * @param $value
     * @return bool|mixed
     */
    static private function safe_base64_encode($value)
    {
        if (!is_string($value)) {
            return false;
        }
        return str_replace(array('+', '/', '='), array('-', '_', '*'), base64_encode($value));
    }

    /**
     * @param $value
     * @return bool|mixed
     */
    static private function safe_base64_decode($value)
    {
        if (!is_string($value)) {
            return false;
        }
        return base64_decode(str_replace(array('-', '_', '*'), array('+', '/', '='), $value));
    }

}

<?php
/**
 * YdSuid
 *
 * Encodes and Decodes a Short Unique Identifier based on an Integer
 *
 * IDEAS TAKEN FROM
 * http://www.pgregg.com/projects/php/base_conversion/base_conversion.inc.phps
 *
 * KNOWN LIMITS
 * encode cannot be larger than 99999999999999
 */
class YdSuid
{
    static $chars = 'kwn7uh2qifbj8te9vp64zxcmayrg50ds31';

    /**
     * Suid::encode()
     *
     * Encodes an Integer into a Short Unique Identifier
     *
     * @param int $id
     * @return string $suid
     */
    public static function encode($id)
    {
        $suid = '';
        while (bccomp($id, 0, 0) != 0) {
            $rem = bcmod($id, 34);
            $id = bcdiv(bcsub($id, $rem, 0), 34, 0);
            $suid = self::$chars[$rem] . $suid;
        }
        return $suid;
    }

    /**
     * Suid::decode()
     *
     * Decodes a Short Universally Unique Identifier into an Integer
     *
     * @param string $suid
     * @return int $id
     */
    public static function decode($suid)
    {
        $id = '';
        $len = strlen($suid);
        for ($i = $len - 1; $i >= 0; $i--) {
            $value = strpos(self::$chars, $suid[$i]);
            $id = bcadd($id, bcmul($value, bcpow(34, ($len - $i - 1))));
        }
        return $id;
    }

}
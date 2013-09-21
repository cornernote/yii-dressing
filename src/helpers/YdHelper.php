<?php
/**
 *
 */
class YdHelper
{

    /**
     * Gets a submitted field
     * used to be named getSubmittedField()
     *
     * @param $field
     * @param null $model
     * @return null
     */
    public static function getSubmittedField($field, $model = null)
    {
        $return = null;
        if ($model && isset($_GET[$model][$field])) {
            $return = $_GET[$model][$field];
        }
        elseif ($model && isset($_POST[$model][$field])) {
            $return = $_POST[$model][$field];
        }
        elseif (isset($_GET[$field])) {
            $return = $_GET[$field];
        }
        elseif (isset($_POST[$field])) {
            $return = $_POST[$field];
        }
        return $return;
    }

    /**
     * @return bool
     */
    public static function isCli()
    {
        return (substr(php_sapi_name(), 0, 3) == 'cli');
    }

    /**
     * @return bool
     */
    public static function isFrontPage()
    {
        return (str_replace(Yii::app()->createUrl('/'), '', Yii::app()->getRequest()->getRequestUri()) == '/');
    }

    /**
     * @static
     * @return bool
     */
    public static function isMobileBrowser()
    {
        return isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE']) || preg_match('/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220)/i', $_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * @static
     * @return bool
     */
    public static function isWindowsServer()
    {
        return (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
    }

    /**
     * @static
     * @return bool
     */
    public static function isLinuxServer()
    {
        return (strtoupper(substr(PHP_OS, 0, 5)) === 'LINUX');
    }

    /**
     * @param $table
     * @param CDbConnection $db
     * @return bool
     */
    public static function tableExists($table, $db = null)
    {
        $db = $db ? $db : Yii::app()->getDb();
        return ($db->createCommand("SHOW TABLES LIKE '" . $table . "'")->queryScalar() == $table);
    }

}
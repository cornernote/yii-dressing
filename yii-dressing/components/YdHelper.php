<?php
/**
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdHelper
{

    /**
     * @return bool
     */
    public static function isHomePage()
    {
        $app = Yii::app();
        return ($app->getHomeUrl() == $app->getRequest()->getRequestUri());
    }

    /**
     * @return bool
     */
    public static function isLoginPage()
    {
        $app = Yii::app();
        $url = $app->getUser()->loginUrl;
        $request = $app->getRequest();
        return ($app->createUrl($url[0], array_splice($url, 1)) == $request->getRequestUri());
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
     * @return bool
     */
    public static function isCli()
    {
        return substr(php_sapi_name(), 0, 3) == 'cli';
    }

    /**
     * @param $tables
     * @param string $mode
     */
    public static function lockTables($tables, $mode = 'WRITE')
    {
        $tableSql = array();
        foreach ($tables as $table => $alias) {
            $tableSql[] = '`' . $table . '` ' . $mode;
            $tableSql[] = '`' . $table . '` ' . $alias . ' ' . $mode;
        }
        Yii::app()->db->createCommand('LOCK TABLES ' . implode(', ', $tableSql))->execute();
    }

    /**
     *
     */
    public static function unlockTables()
    {
        Yii::app()->db->createCommand("UNLOCK TABLES")->execute();
    }
}
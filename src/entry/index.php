<?php
/**
 * Yii Web
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-skeleton
 * @license http://www.gnu.org/copyleft/gpl.html
 */

// start the timer
defined('YII_BEGIN_TIME') or define('YII_BEGIN_TIME', microtime(true));

// ensure cli is not being called
if (substr(php_sapi_name(), 0, 3) == 'cli') {
    trigger_error('This script cannot be run from a CLI.', E_USER_ERROR);
}

// include config
require_once(dirname(dirname($_SERVER['SCRIPT_FILENAME'])) . DS . 'vendor' . DS . 'mrphp' . DS . 'yii-dressing' . DS . 'src' . DS . 'components' . DS . 'YdConfig.php');
require_once(dirname(dirname($_SERVER['SCRIPT_FILENAME'])) . DS . 'app' . DS . 'components' . DS . 'Config.php');
$config = Config::instance(array('appPath' => dirname(dirname($_SERVER['SCRIPT_FILENAME'])) . DS . 'app'))->getWebConfig();

// include Yii
require_once(dirname(dirname($_SERVER['SCRIPT_FILENAME'])) . DS . 'vendor' . DS . 'yiisoft' . DS . 'yii' . DS . 'framework' . DS . 'yii.php');

// create the app
$app = Yii::createWebApplication($config);

// record the audit
YdAudit::findCurrent();

// run the Yii app (Yii-Haw!)
$app->run();
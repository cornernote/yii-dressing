<?php
/**
 * Yii CLI
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-skeleton
 * @license http://www.gnu.org/copyleft/gpl.html
 */

// start the timer
$_ENV['_start'] = microtime(true);

// define directory separator shortcut
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// ensure cli is being called
if (substr(php_sapi_name(), 0, 3) != 'cli') {
    trigger_error('This script needs to be run from a CLI.', E_USER_ERROR);
}

// include Yiic
require_once(dirname($_SERVER['SCRIPT_FILENAME']) . DS . 'vendor' . DS . 'yiisoft' . DS . 'yii' . DS . 'framework' . DS . 'yii.php');

// include config
require_once(dirname($_SERVER['SCRIPT_FILENAME']) . DS . 'vendor' . DS . 'mrphp' . DS . 'yii-dressing' . DS . 'src' . DS . 'components' . DS . 'YdConfig.php');
$config = YdConfig::instance(array('appPath' => dirname($_SERVER['SCRIPT_FILENAME']) . DS . 'app'))->getCliConfig();

// run the Yii CLI app (Yii-Haw!)
require_once(dirname($_SERVER['SCRIPT_FILENAME']) . DS . 'vendor' . DS . 'yiisoft' . DS . 'yii' . DS . 'framework' . DS . 'yiic.php');
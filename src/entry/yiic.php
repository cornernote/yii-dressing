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
defined('APP_START') or define('APP_START', microtime(true));

// ensure cli is being called
if (substr(php_sapi_name(), 0, 3) != 'cli') {
    trigger_error('This script needs to be run from a CLI.', E_USER_ERROR);
}

// include config
require_once(dirname($_SERVER['SCRIPT_FILENAME']) . DS . 'vendor' . DS . 'mrphp' . DS . 'yii-dressing' . DS . 'src' . DS . 'components' . DS . 'YdConfig.php');
require_once(dirname($_SERVER['SCRIPT_FILENAME']) . DS . 'app' . DS . 'components' . DS . 'Config.php');
$config = Config::instance(array('appPath' => dirname($_SERVER['SCRIPT_FILENAME']) . DS . 'app'))->getCliConfig();

// include Yiic
require_once(dirname($_SERVER['SCRIPT_FILENAME']) . DS . 'vendor' . DS . 'yiisoft' . DS . 'yii' . DS . 'framework' . DS . 'yii.php');

// fix for fcgi
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

// create the app
$app = Yii::createConsoleApplication($config);
$app->commandRunner->addCommands(YII_PATH . '/cli/commands');
$env = @getenv('YII_CONSOLE_COMMANDS');
if (!empty($env))
    $app->commandRunner->addCommands($env);

// record the audit
YdAudit::findCurrent();

// run the Yii CLI app (Yii-Haw!)
$app->run();
<?php
/**
 * defines
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-skeleton
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

/**
 * Gets the application start timestamp.
 */
defined('YII_BEGIN_TIME') or define('YII_BEGIN_TIME', microtime(true));

/**
 * Defines the systems directory separator.
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

/**
 * Defines if the script is being called from a command line interface.
 */
defined('YII_DRESSING_CLI') or define('YII_DRESSING_CLI', (substr(php_sapi_name(), 0, 3) == 'cli'));

/**
 * Defines the Vendor path.
 */
defined('VENDOR_PATH') or define('VENDOR_PATH', str_replace(array('\\', '/'), DS, dirname(dirname(dirname(dirname(__FILE__))))));

/**
 * Defines the Yii framework path.
 */
defined('YII_PATH') or define('YII_PATH', str_replace(array('\\', '/'), DS, VENDOR_PATH . '/yiisoft/yii/framework'));

/**
 * Defines a hash that is used for encoding and decoding data.
 */
defined('YII_DRESSING_HASH') or define('YII_DRESSING_HASH', false);

/**
 * Defines if we should use the yii-debug-toolbar.
 */
defined('YII_DEBUG_TOOLBAR') or define('YII_DEBUG_TOOLBAR', false);

/**
 * Defines the filesystem path to the public directory of the application.
 */
defined('PUBLIC_PATH') or define('PUBLIC_PATH', str_replace(array('\\', '/'), DS, dirname(VENDOR_PATH) . DS . 'public'));

/**
 * Defines the public hostname of the application.
 */
defined('PUBLIC_HOST') or define('PUBLIC_HOST', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost');

/**
 * Defines the public url to the application.
 */
defined('PUBLIC_URL') or define('PUBLIC_URL', '');

<?php
/**
 * YdBase
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

/**
 * Include the Constant Definitions
 */
require_once(dirname(__FILE__) . DS . 'defines.php');

/**
 * Include the Yii Framework
 */
require_once(YII_PATH . DS . 'YiiBase.php');

/**
 * YdBase is a helper class serving common framework functionalities.
 *
 * Do not use YdBase directly. Instead, use its child class {@link Yii} where you can customize methods of YdBase.
 *
 * @package dressing
 */
class YdBase extends YiiBase
{

    /**
     * Merge YdBase default configuration with the given configuration.
     *
     * @param string $class the application class name
     * @param mixed $config application configuration.
     * @return mixed the application instance
     */
    public static function createApplication($class, $config = null)
    {
        return parent::createApplication($class, self::mergeArray(self::getConfig(), self::loadConfig($config)));
    }

    /**
     * Creates a CWebApplication, in addition it will configure the controller map and log routes as well as remove
     * config items that are incompatibale with CWebApplication.
     * @param null $config
     * @return CWebApplication
     * @throws CException if it is called from CLI
     */
    public static function createWebApplication($config = null)
    {
        if (YII_DRESSING_CLI)
            throw new CException(Yii::t('dressing', 'This script cannot be run from a CLI.'));

        // load the config array
        $config = self::loadConfig($config);

        // remove incompatibale items
        $excludeItems = array('commandMap');
        foreach ($excludeItems as $excludeItem)
            if (array_key_exists($excludeItem, $config))
                unset($config[$excludeItem]);

        // log routes (only setup if not already defined)
        if (!isset($config['components']['log']['routes'])) {
            $config['components']['log']['routes'] = array();
            $config['components']['log']['routes'][] = array(
                'class' => YII_DEBUG ? 'CWebLogRoute' : 'CFileLogRoute',
                'levels' => 'error, warning',
            );
            if (YII_DEBUG_TOOLBAR)
                $config['components']['log']['routes'][] = array(
                    'class' => 'vendor.malyshev.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'levels' => 'profile',
                );
        }
        return self::createApplication('CWebApplication', $config);
    }

    /**
     * Creates a CConsoleApplication, in addition it will configure the command map as well as remove config items that
     * are incompatibale with CConsoleApplication.
     * @param null $config
     * @return CConsoleApplication
     * @throws CException if it is not called from CLI
     */
    public static function createConsoleApplication($config = null)
    {
        if (!YII_DRESSING_CLI)
            throw new CException(Yii::t('dressing', 'This script can only run from a CLI.'));

        // load the config array
        $config = self::loadConfig($config);

        // remove incompatibale items
        $excludeItems = array('theme', 'controllerMap');
        foreach ($excludeItems as $excludeItem)
            if (array_key_exists($excludeItem, $config))
                unset($config[$excludeItem]);

        // remove things from preload
        if (isset($config['preload'])) {
            $excludePreloads = array('bootstrap');
            foreach ($config['preload'] as $k => $preload)
                if (in_array($preload, $excludePreloads)) unset($config['preload'][$k]);
        }

        // create app
        $app = self::createApplication('CConsoleApplication', $config);

        // fix for absolute url
        $app->getRequest()->setBaseUrl(PUBLIC_URL);

        // add Yii commands
        $app->commandRunner->addCommands(YII_PATH . '/cli/commands');
        $env = @getenv('YII_CONSOLE_COMMANDS');
        if (!empty($env))
            $app->commandRunner->addCommands($env);

        return $app;
    }

    /**
     * Config can be a string, in which case a file and optional local file override are loaded.
     * The files should return arrays.
     * @param $config
     * @return array|mixed
     */
    public static function loadConfig($config)
    {
        if (!is_string($config))
            return $config;
        $local = substr($config, 0, -4) . '.local.php';
        if (file_exists($local)) {
            $local = require($local);
            if (is_array($local))
                return self::mergeArray(require($config), $local);
        }
        return require($config);
    }

    /**
     * YdBase Config
     * @return array
     */
    public static function getConfig()
    {
        $config = array();
        if (YII_DEBUG && !YII_DRESSING_CLI && !isset($config['modules']['gii'])) {
            $config['modules']['gii'] = array(
                'class' => 'system.gii.GiiModule',
                'generatorPaths' => array(
                    'dressing.gii',
                    'vendor.mrphp.gii-modeldoc-generator',
                ),
                'ipFilters' => array('127.0.0.1'),
                'password' => false,
            );
        }
        return $config;
    }

    /**
     * Merges two or more arrays into one recursively.
     * Required internally before Yii is loaded.  Use CMap::mergeArray() for normal usage in other files.
     *
     * @param array $a array to be merged to
     * @param array $b array to be merged from. You can specify additional arrays via third argument, fourth argument etc.
     * @return array the merged array (the original arrays are not changed.)
     * @see CMap::mergeArray
     */
    private static function mergeArray($a, $b)
    {
        $args = func_get_args();
        $res = array_shift($args);
        while (!empty($args)) {
            $next = array_shift($args);
            foreach ($next as $k => $v) {
                if (is_integer($k))
                    isset($res[$k]) ? $res[] = $v : $res[$k] = $v;
                elseif (is_array($v) && isset($res[$k]) && is_array($res[$k]))
                    $res[$k] = self::mergeArray($res[$k], $v);
                else
                    $res[$k] = $v;
            }
        }
        return $res;
    }

}

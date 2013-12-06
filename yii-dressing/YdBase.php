<?php
/**
 * YdBase
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-skeleton
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
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

        // add controller map
        if (!isset($config['controllerMap']))
            $config['controllerMap'] = array();
        $config['controllerMap'] = self::mergeArray(self::getControllerMap(), $config['controllerMap']);

        // remove incompatibale items
        // do not use isset() to check, as it will return false if the key is set to null
        unset($config['commandMap']);

        // log routes (only setup if not already defined)
        if (!isset($config['components']['log']['routes'])) {
            $config['components']['log']['routes'] = array();
            $config['components']['log']['routes'][] = array(
                'class' => YII_DEBUG ? 'CWebLogRoute' : 'CFileLogRoute',
                'levels' => 'error, warning',
            );
            if (YII_DEBUG_TOOLBAR)
                $config['components']['log']['routes'][] = array(
                    'class' => 'vendor.malyshev.yii-debug-toolbar.yii-debug-toolbar.YiiDebugToolbarRoute',
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
        // do not use isset() to check, as it will return false if the key is set to null
        unset($config['theme']);
        unset($config['controllerMap']);

        // remove things from preload
        if (isset($config['preload'])) {
            $excludeConsolePreloads = array('bootstrap');
            foreach ($config['preload'] as $k => $preload)
                if (in_array($preload, $excludeConsolePreloads)) unset($config['preload'][$k]);
        }

        // add command map
        if (!isset($config['commandMap']))
            $config['commandMap'] = array();
        $config['commandMap'] = self::mergeArray(self::getCommandMap(), $config['commandMap']);

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
        $config = array(
            'components' => array(
                'dressing' => array(
                    'class' => 'dressing.YdDressing',
                ),
                'errorHandler' => array(
                    'class' => 'dressing.components.YdErrorHandler',
                    'errorAction' => 'site/error',
                ),
                'fatalErrorCatch' => array(
                    'class' => 'dressing.components.YdFatalErrorCatch',
                ),
                'user' => array(
                    'class' => 'dressing.components.YdWebUser',
                    'allowAutoLogin' => true,
                    'loginUrl' => array('/account/login'),
                ),
                'returnUrl' => array(
                    'class' => 'dressing.components.YdReturnUrl',
                ),
                'bootstrap' => array(
                    'class' => 'bootstrap.components.Bootstrap',
                    'fontAwesomeCss' => true,
                ),
                'urlManager' => array(
                    'urlFormat' => isset($_GET['r']) ? 'get' : 'path', // allow filters in audit/index work
                    'showScriptName' => false,
                ),
                'cacheFile' => array(
                    'class' => 'CFileCache',
                ),
                'cacheDb' => array(
                    'class' => 'CDbCache',
                ),
                'cacheApc' => array(
                    'class' => 'CApcCache',
                ),
                'log' => array(
                    'class' => 'CLogRouter',
                ),
                'clientScript' => array(
                    'class' => 'YdClientScript',
                ),
                'session' => array(
                    'class' => 'CCacheHttpSession',
                    'cacheID' => 'cacheApc',
                ),
                'email' => array(
                    'class' => 'dressing.components.YdEmail',
                ),
                'swiftMailer' => array(
                    'class' => 'dressing.components.YdSwiftMailer',
                ),
                'auditTracker' => array(
                    'class' => 'dressing.components.YdAuditTracker',
                ),
                'format' => array(
                    'class' => 'dressing.components.YdFormatter',
                ),
                'reCapture' => array(
                    'class' => 'dressing.components.YdReCapture',
                ),
                'widgetFactory' => array(
                    'widgets' => array(
                        'TbMenu' => array(
                            'activateParents' => true,
                        ),
                        'TbCKEditor' => array(
                            'editorOptions' => array(
                                'toolbar_Full' => array(
                                    array('name' => 'document', 'items' => array('Source', '-', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', '-', 'Templates')),
                                    array('name' => 'clipboard', 'items' => array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo')),
                                    array('name' => 'editing', 'items' => array('Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt')),
                                    array('name' => 'forms', 'items' => array('Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField')),
                                    array('name' => 'basicstyles', 'items' => array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat')),
                                    array('name' => 'paragraph', 'items' => array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl')),
                                    array('name' => 'links', 'items' => array('Link', 'Unlink', 'Anchor')),
                                    array('name' => 'insert', 'items' => array('Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe')),
                                    array('name' => 'styles', 'items' => array('Styles', 'Format', 'Font', 'FontSize')),
                                    array('name' => 'colors', 'items' => array('TextColor', 'BGColor')),
                                    array('name' => 'tools', 'items' => array('Maximize', 'ShowBlocks', '-', 'About')),
                                ),
                                'toolbar_Basic' => array(
                                    array('Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About'),
                                ),
                                'toolbar_DressingFull' => array(
                                    array('name' => 'tools', 'items' => array('Source', 'Maximize', 'ShowBlocks')),
                                    array('name' => 'clipboard', 'items' => array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo')),
                                    array('name' => 'basicstyles', 'items' => array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat')),
                                    array('name' => 'paragraph', 'items' => array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock')),
                                    array('name' => 'links', 'items' => array('Link', 'Unlink', 'Anchor')),
                                    array('name' => 'insert', 'items' => array('Image', 'Table', 'HorizontalRule', 'SpecialChar')),
                                    array('name' => 'styles', 'items' => array('Format')),
                                ),
                                'toolbar_DressingBasic' => array(
                                    array('Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'),
                                ),
                                'toolbar' => 'DressingFull',
                            ),
                        ),
                    ),
                ),
            ),
        );
        if (YII_DEBUG && !YII_DRESSING_CLI && !isset($config['modules']['gii'])) {
            $config['modules']['gii'] = array(
                'class' => 'system.gii.GiiModule',
                'generatorPaths' => array(
                    'dressing.gii',
                ),
                'ipFilters' => array('127.0.0.1'),
                'password' => false,
            );
        }
        return $config;
    }

    /**
     * YdBase Controller Map
     * @return array
     */
    public static function getControllerMap()
    {
        $controllers = array(
            'account' => 'dressing.controllers.YdAccountController',
            'attachment' => 'dressing.controllers.YdAttachmentController',
            'audit' => 'dressing.controllers.YdAuditController',
            'auditTrail' => 'dressing.controllers.YdAuditTrailController',
            'contactUs' => 'dressing.controllers.YdContactUsController',
            'emailSpool' => 'dressing.controllers.YdEmailSpoolController',
            'emailTemplate' => 'dressing.controllers.YdEmailTemplateController',
            'error' => 'dressing.controllers.YdErrorController',
            'lookup' => 'dressing.controllers.YdLookupController',
            'siteMenu' => 'dressing.controllers.YdSiteMenuController',
            'role' => 'dressing.controllers.YdRoleController',
            'setting' => 'dressing.controllers.YdSettingController',
            'user' => 'dressing.controllers.YdUserController',
        );
        // unset controllers that app has defined
        foreach (array_keys($controllers) as $controller)
            if (file_exists(APP_PATH . DS . 'controllers' . DS . ucfirst($controller) . 'Controller.php'))
                unset($controllers[$controller]);
        return $controllers;
    }

    /**
     * YdBase Command Map
     * @return array
     */
    public static function getCommandMap()
    {
        $commands = array(
            'migrate' => array(
                'class' => 'system.cli.commands.MigrateCommand',
                'migrationPath' => 'application.migrations',
                'migrationTable' => 'migration',
                'connectionID' => 'db',
                'templateFile' => 'dressing.migrations.templates.migrate_template',
            ),
            'emailSpool' => 'dressing.commands.YdEmailSpoolCommand',
            'errorEmail' => 'dressing.commands.YdErrorEmailCommand',
        );
        // unset commands that app has defined
        foreach (array_keys($commands) as $command)
            if (file_exists(APP_PATH . DS . 'commands' . DS . ucfirst($command) . 'Command.php'))
                unset($commands[$command]);
        return $commands;
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

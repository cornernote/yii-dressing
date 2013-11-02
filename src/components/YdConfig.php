<?php
/**
 * YdConfig
 *
 * @property array $dbConfig
 * @property array $webConfig
 * @property array $cliConfig
 * @property array $mainConfig
 * @property array $paramsConfig
 * @property array $importConfig
 * @property array $componentsConfig
 * @property array $modulesConfig
 * @property array $preloadConfig
 * @property array $aliasesConfig
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-skeleton
 * @license http://www.gnu.org/copyleft/gpl.html
 */
class YdConfig
{

    /**
     * @var null
     */
    public $appPath = null;

    /**
     * @var array
     */
    static private $_settings = array();

    /**
     * @param array $config
     * @return YdConfig
     */
    static function instance($config = array())
    {
        return new YdConfig($config);
    }

    /**
     * @param array $config
     */
    public function __construct($config = array())
    {
        if (empty($config['appPath'])) {
            throw new Exception('You must define YdConfig.appPath.');
        }
        foreach ($config as $k => $v) {
            $this->$k = $v;
        }
        $this->init();
    }

    /**
     * @param $name
     * @return mixed
     * @throws CException
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter))
            return $this->$getter();
        throw new CException(Yii::t('yii', 'Property "{class}.{property}" is not defined.', array('{class}' => get_class($this), '{property}' => $name)));
    }

    /**
     *
     */
    public function init()
    {
        // load settings
        self::$_settings = $this->getSettingsConfig();
        $_config_db = mysql_connect($this->dbConfig['host'], $this->dbConfig['user'], $this->dbConfig['pass']);
        if ($_config_db && mysql_select_db($this->dbConfig['name'], $_config_db)) {
            mysql_set_charset('utf8', $_config_db);
            $settingTable = isset($settingTable) ? $settingTable : 'setting'; // decide which table to use
            $q = mysql_query("SELECT * FROM {$settingTable}", $_config_db);
            if ($q) while ($row = mysql_fetch_assoc($q))
                self::$_settings[$row['key']] = $row['value'];
            mysql_close($_config_db);
            unset($_config_db);
        }

        // set debug levels
        if ($this->setting('debug')) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            ini_set('log_errors', 1);
            defined('YII_DEBUG') or define('YII_DEBUG', true);
            defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', $this->setting('debug'));
        }
        else {
            error_reporting(0);
            ini_set('display_errors', 0);
            ini_set('log_errors', 0);
            defined('YII_DEBUG') or define('YII_DEBUG', false);
        }

        // set default php settings
        date_default_timezone_set($this->setting('timezone'));
        $timeLimit = self::isCli() ? 0 : $this->setting('timeLimit');
        set_time_limit($timeLimit);
        ini_set('max_execution_time', $timeLimit);
        ini_set('memory_limit', $this->setting('memoryLimit'));
    }

    /**
     * @return array
     */
    private function loadConfig($name, $config)
    {
        $file = $this->appPath . DS . 'config' . DS . $name . '.php';
        $app = file_exists($file) ? require($file) : array();

        $file = $this->appPath . DS . 'config' . DS . $name . '.local.php';
        $local = file_exists($file) ? require($file) : array();

        return self::mergeArray($config, $app, $local);
    }

    /**
     * @return array
     */
    public function getDbConfig()
    {
        $config = array(
            'host' => 'localhost',
            'user' => 'root',
            'pass' => '',
            'name' => 'test',
            'setting' => 'setting',
        );
        return $this->loadConfig('db', $config);
    }

    /**
     * @return array
     */
    public function getWebConfig()
    {
        $config = array();

        // web only preloads
        $config['preload'][] = 'bootstrap';

        // enable database profiling
        $config['components']['db']['enableProfiling'] = $this->setting('debugDb');
        $config['components']['db']['enableParamLogging'] = $this->setting('debugDb');

        // log routes
        $config['components']['log']['routes'] = array();
        if ($this->setting('debug')) {
            // debug, web log route
            $config['components']['log']['routes'][] = array(
                'class' => 'CWebLogRoute',
                'levels' => $this->setting('debugLevels'),
                //'levels' => 'trace, info, error, warning, profile',
            );
            if ($this->setting('debugDb')) {
                $config['components']['log']['routes'][] = array(
                    'class' => 'YdProfileLogRoute',
                    'levels' => 'profile',
                );
            }
        }
        else {
            // no debug, file log route
            $config['components']['log']['routes'][] = array(
                'class' => 'CFileLogRoute',
                'levels' => $this->setting('debugLevels'),
            );
        }

        // assets
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptName == '/') {
            $scriptName = '';
        }
        $config['components']['assetManager'] = array(
            'class' => 'dressing.components.YdAssetManager',
            'basePath' => dirname($_SERVER['SCRIPT_FILENAME']) . DS . 'assets',
            'baseUrl' => $scriptName . '/assets',
            'linkAssets' => true,
        );

        // themes
        if ($this->setting('theme')) {
            $config['theme'] = $this->setting('theme');
        }
        $config['components']['themeManager'] = array(
            'basePath' => $this->appPath . DS . 'themes',
        );

        // controller map
        $config['controllerMap'] = array(
            'account' => 'dressing.controllers.YdAccountController',
            'attachment' => 'dressing.controllers.YdAttachmentController',
            'audit' => 'dressing.controllers.YdAuditController',
            'auditTrail' => 'dressing.controllers.YdAuditTrailController',
            'contactUs' => 'dressing.controllers.YdContactUsController',
            'emailSpool' => 'dressing.controllers.YdEmailSpoolController',
            'emailTemplate' => 'dressing.controllers.YdEmailTemplateController',
            'error' => 'dressing.controllers.YdErrorController',
            'lookup' => 'dressing.controllers.YdLookupController',
            'menu' => 'dressing.controllers.YdSiteMenuController',
            'role' => 'dressing.controllers.YdRoleController',
            'setting' => 'dressing.controllers.YdSettingController',
            'user' => 'dressing.controllers.YdUserController',
        );

        return $this->loadConfig('web', self::mergeArray($this->getMainConfig(), $config));
    }

    /**
     * @return array
     */
    public function getCliConfig()
    {
        $config = array();

        // command map
        $config['commandMap']['migrate'] = array(
            'class' => 'system.cli.commands.MigrateCommand',
            'migrationPath' => 'application.migrations',
            'migrationTable' => 'migration',
            'connectionID' => 'db',
            'templateFile' => 'dressing.migrations.templates.migrate_template',
        );
        $config['commandMap']['emailSpool'] = 'dressing.commands.EmailSpoolCommand';
        $config['commandMap']['errorEmail'] = 'dressing.commands.ErrorEmailCommand';

        return $this->loadConfig('cli', self::mergeArray($this->getMainConfig(), $config));
    }

    /**
     * @return array
     */
    public function getMainConfig()
    {
        $config = array(

            // yii settings
            'id' => $this->setting('id'),
            'name' => $this->setting('name'),
            'language' => $this->setting('language'),
            'charset' => $this->setting('charset'),
            'params' => $this->getParamsConfig(),

            // paths
            'basePath' => $this->appPath,
            'runtimePath' => dirname($this->appPath) . DS . 'runtime',
            'aliases' => $this->getAliasesConfig(),
            'import' => $this->getImportConfig(),

            // libraries
            'modules' => $this->getModulesConfig(),
            'components' => $this->getComponentsConfig(),
            'preload' => $this->getPreloadConfig(),

        );
        return $this->loadConfig('main', $config);
    }

    /**
     * @return array
     */
    public function getComponentsConfig()
    {
        $config = array(
            'widgetFactory' => array(
                'widgets' => array(
                    'TbMenu' => array(
                        'activateParents' => true,
                    ),
                ),
            ),
            'dressing' => array(
                'class' => 'dressing.YiiDressing',
                'tableMap' => array(
                    'YdSetting' => $this->dbConfig['setting'],
                ),
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
            'db' => array(
                'connectionString' => "mysql:host={$this->dbConfig['host']};dbname={$this->dbConfig['name']}",
                'emulatePrepare' => true,
                'username' => $this->dbConfig['user'],
                'password' => $this->dbConfig['pass'],
                'charset' => 'utf8',
                'schemaCachingDuration' => 3600,
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
            'cache' => array(
                'class' => 'CMemCache',
                'keyPrefix' => $this->setting('id') . '.',
                'servers' => array(
                    array(
                        'host' => '127.0.0.1',
                        'port' => 11211,
                        'weight' => 10,
                    ),
                ),
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
            'swiftMailer' => array(
                'class' => 'dressing.extensions.swiftMailer.SwiftMailer',
            ),
        );
        return $this->loadConfig('components', $config);
    }

    /**
     * @return array
     */
    public function getModulesConfig()
    {
        $config = array();

        if (YII_DEBUG) {
            $config['gii'] = array(
                'class' => 'system.gii.GiiModule',
                'password' => '123456',
                'generatorPaths' => array(
                    'dressing.gii',
                ),
                'ipFilters' => array('127.0.0.1'),
            );
        }

        return $this->loadConfig('modules', $config);
    }

    /**
     * @return array
     */
    public function getPreloadConfig()
    {
        $config = array(
            'log',
            'dressing',
            'fatalErrorCatch',
        );
        return $this->loadConfig('preload', $config);
    }

    /**
     * @return array
     */
    public function getImportConfig()
    {
        $config = array(
            'application.commands.*',
            'application.models.*',
            'application.components.*',
        );
        return $this->loadConfig('import', $config);
    }

    /**
     * @return array
     */
    public function getAliasesConfig()
    {
        $config = array(
            'core' => $this->setting('path'),
            'public' => dirname($this->appPath) . DS . 'public',
            'vendor' => dirname($this->appPath) . DS . 'vendor',
            'dressing' => dirname($this->appPath) . DS . 'vendor' . DS . 'mrphp' . DS . 'yii-dressing' . DS . 'src',
            'bootstrap' => dirname($this->appPath) . DS . 'vendor' . DS . 'clevertech' . DS . 'yii-booster' . DS . 'src',
        );
        return $this->loadConfig('aliases', $config);
    }

    /**
     * @return array
     */
    public function getParamsConfig()
    {
        $config = array();
        return $this->loadConfig('params', $config);
    }

    /**
     * @return array
     */
    public function getSettingsConfig()
    {
        $config = array(
            'id' => 'app',
            'name' => 'App',
            'brand' => 'App',
            'language' => 'en',
            'charset' => 'utf-8',
            'timezone' => 'GMT',
            'theme' => null,
            'debug' => true,
            'debugDb' => false,
            'debugLevels' => 'error,warning',
            'timeLimit' => 60,
            'memoryLimit' => '128M',
            'email' => 'webmaster@localhost',
            'website' => 'localhost',
            'dateFormat' => 'Y-m-d',
            'dateFormatLong' => 'Y-m-d',
            'timeFormat' => 'H:i:s',
            'timeFormatLong' => 'H:i:s',
            'dateTimeFormat' => 'Y-m-d H:i:s',
            'dateTimeFormatLong' => 'Y-m-d H:i:s',
            'allowAutoLogin' => true,
            'rememberMe' => true,
            'defaultPageSize' => '10',
            'recaptcha' => false,
            'recaptchaPrivate' => '6LeBItQSAAAAALA4_G05e_-fG5yH_-xqQIN8AfTD',
            'recaptchaPublic' => '6LeBItQSAAAAAG_umhiD0vyxXbDFbVMPA0kxZUF6',
            'hashKey' => 'abc123',
            'landingYoutube' => 'dR9qPq-yVBY',
            'landingYoutubeTitle' => 'Manage Your Master Key Systems Online',
            'mission' => 'Become an awesome PHP Yii Library!',
            'errorEmail' => 'webmaster@localhost',
            'serverName' => '',
            'scriptPath' => '',
            'scriptUrl' => '',
            'audit' => false,
        );
        return $this->loadConfig('settings', $config);
    }

    /**
     * @static
     * @param string $name
     * @return string
     */
    public static function setting($name)
    {
        if (isset(self::$_settings[$name])) {
            return self::$_settings[$name];
        }
        return false;
    }

    /**
     * @static
     * @return array
     */
    public static function settings()
    {
        return self::$_settings;
    }

    /**
     * Merges two or more arrays into one recursively.
     * If each array has an element with the same string key value, the latter
     * will overwrite the former (different from array_merge_recursive).
     * Recursive merging will be conducted if both arrays have an element of array
     * type and are having the same key.
     * For integer-keyed elements, the elements from the latter array will
     * be appended to the former array.
     * @param array $a array to be merged to
     * @param array $b array to be merged from. You can specify additional
     * arrays via third argument, fourth argument etc.
     * @return array the merged array (the original arrays are not changed.)
     * @see mergeWith
     */
    public static function mergeArray($a, $b)
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

    /**
     * @return bool
     */
    public static function isCli()
    {
        return (substr(php_sapi_name(), 0, 3) == 'cli');
    }

}
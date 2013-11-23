<?php
/**
 * YdConfig implements protocols for configuring the environment before the application is loaded.
 *
 *
 * Initializing
 *
 * When initializing, YdConfig will load data from the json file, then define constants, then setup the PHP environment:
 * <pre>
 * $config = YdConfig::createInstance('config.json');
 * </pre>
 *
 *
 * Static Access
 *
 * YdConfig can be accessed using a static instance:
 * <pre>
 * $config = YdConfig::instance();
 * </pre>
 *
 *
 * Accessing Configuration Data
 *
 * Data can be written using setConfig() and read using getConfig():
 * <pre>
 * $config->setConfig('text','hello world');
 * $a=$config->getConfig('text','default text');
 * </pre>
 *
 *
 * Credits
 *
 * This class was written and compiled by Brett O'Donnell and Zain ul abidin.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain ul abidin <zainengineer@gmail.com>
 * @copyright Copyright (c) 2013, Brett O'Donnell and Zain ul abidin
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class YdConfig
{

    /**
     * @var string full path to the json config file
     */
    public $file;

    /**
     * @var array config keys and values
     */
    private $_configs = array();

    /**
     * The instantiated object
     *
     * @var Config
     * @see instance
     */
    static private $_instance;

    /**
     * Returns a static instance with the config values assigned to properties.
     * It is provided for preparing the instance for static instance methods.
     *
     * @param null|string $file
     * @return YdConfig the instantiated object
     * @see __construct
     */
    public static function createInstance($file = null)
    {
        $class = get_called_class();
        return new $class($file);
    }

    /**
     * Returns a static instance.
     * It is provided for invoking static instance methods.
     *
     * @return Config the instantiated object
     * @throws Exception if the instance has not been created
     * @see createInstance
     */
    public static function instance()
    {
        if (isset(self::$_instance))
            return self::$_instance;
        throw new Exception('Instance has not been created.');
    }

    /**
     * Constructs the instance.
     * Do not call this method.
     * This is a PHP magic method that we override to allow the following syntax to set initial properties:
     * <pre>
     * $config = new Config('config.json');
     * </pre>
     *
     * @param null|string $file
     */
    public function __construct($file = null)
    {
        $this->file = $file;
        $this->initConfig();
        $this->initConstants();
        $this->initEnvironment();
        self::$_instance = $this;
    }

    /**
     * Return the value of a config key
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getConfig($name, $default = null)
    {
        return isset($this->_configs[$name]) ? $this->_configs[$name] : $default;
    }

    /**
     * Return an array of all config keys and values
     *
     * @return array
     */
    public function getConfigs()
    {
        return $this->_configs;
    }

    /**
     * Set the value of a config key
     *
     * @param $name
     * @param $value
     */
    public function setConfig($name, $value)
    {
        $this->setConfigs(array($name => $value));
    }

    /**
     * Set the value of all config keys and values and writes to the config file
     *
     * @param $configs
     */
    public function setConfigs($configs)
    {
        foreach ($configs as $name => $value)
            if ($value !== null)
                $this->_configs[$name] = $value;
            elseif (isset($this->_configs[$name]))
                unset($this->_configs[$name]);
        file_put_contents($this->file, json_encode($this->_configs));
    }

    /**
     * Load data from config file into the config array.
     */
    private function initConfig()
    {
        // return existing object
        if ($this->_configs)
            return;

        // get the database name
        if (!$this->file)
            $this->file = dirname(__FILE__) . DIRECTORY_SEPARATOR . get_class($this) . '.json';

        // create the folder
        if (!file_exists(dirname($this->file)))
            if (!mkdir(dirname($this->file), 0777, true))
                throw new Exception(strtr('Could not create directory for {class}.', array(
                    '{class}' => get_class($this),
                )));

        // create the file
        if (!file_exists($this->file))
            if (!file_put_contents($this->file, json_encode($this->_configs)))
                throw new Exception(strtr('Could not create file for {class}.', array(
                    '{class}' => get_class($this),
                )));

        $this->_configs = json_decode(file_get_contents($this->file), true);
    }

    /**
     * Defines any constant that has not yet been defined.
     */
    private function initConstants()
    {
        $constants = array(
            'DS',
            'APP_PATH',
            'APP_CONFIG',
            'VENDOR_PATH',
            'YII_DEBUG',
            'YII_TRACE_LEVEL',
            'YII_ENABLE_EXCEPTION_HANDLER',
            'YII_ENABLE_ERROR_HANDLER',
            'YII_PATH',
            'YII_ZII_PATH',
            'YII_BOOSTER_PATH',
            'YII_DRESSING_PATH',
            'YII_DRESSING_CLI',
            'YII_DRESSING_LOG_LEVELS',
            'PUBLIC_PATH',
            'PUBLIC_HOST',
            'PUBLIC_URL',
        );
        foreach ($constants as $name)
            if (!defined($name) && ($config = $this->getConfig($name)) !== null)
                define($name, $config);

        // bools and strings
        defined('YII_DEBUG') or define('YII_DEBUG', false);
        defined('YII_DEBUG_TOOLBAR') or define('YII_DEBUG_TOOLBAR', YII_DEBUG);
        defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', YII_DEBUG);
        defined('YII_ENABLE_EXCEPTION_HANDLER') or define('YII_ENABLE_EXCEPTION_HANDLER', true);
        defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER', true);
        defined('YII_DRESSING_CLI') or define('YII_DRESSING_CLI', (substr(php_sapi_name(), 0, 3) == 'cli'));
        defined('YII_DRESSING_LOG_LEVELS') or define('YII_DRESSING_LOG_LEVELS', 'error, warning');

        // paths
        defined('DS') or define('DS', DIRECTORY_SEPARATOR);
        defined('YII_DRESSING_PATH') or define('YII_DRESSING_PATH', dirname(__FILE__));
        defined('VENDOR_PATH') or define('VENDOR_PATH', dirname(dirname(dirname(dirname(YII_DRESSING_PATH)))) . DS . 'vendor');
        defined('APP_PATH') or define('APP_PATH', dirname(VENDOR_PATH) . DS . 'app');
        defined('APP_CONFIG') or define('APP_CONFIG', APP_PATH . DS . 'config' . DS . 'main.php');
        defined('YII_PATH') or define('YII_PATH', VENDOR_PATH . DS . 'yiisoft' . DS . 'yii' . DS . 'framework');
        defined('YII_ZII_PATH') or define('YII_ZII_PATH', YII_PATH . DS . 'zii');
        defined('YII_BOOSTER_PATH') or define('YII_BOOSTER_PATH', VENDOR_PATH . DS . 'clevertech' . DS . 'yii-booster' . DS . 'src');
        defined('PUBLIC_PATH') or define('PUBLIC_PATH', dirname(APP_PATH) . DS . 'public');

        // public_host and public_url are saved into config when accessed via web so that the value is available for cli
        if (!defined('PUBLIC_HOST')) {
            define('PUBLIC_HOST', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
            if (!YII_DRESSING_CLI)
                $this->setConfig('PUBLIC_HOST', PUBLIC_HOST);
        }
        if (!defined('PUBLIC_URL')) {
            $url = isset($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : '';
            if ($url == '/')
                $url = '';
            define('PUBLIC_URL', $url);
            if (!YII_DRESSING_CLI)
                $this->setConfig('PUBLIC_URL', PUBLIC_URL);
        }

        // hash needs to be defined once and saved into config so that it does not change
        if (!defined('YII_DRESSING_HASH')) {
            define('YII_DRESSING_HASH', md5(uniqid(true)));
            $this->setConfig('YII_DRESSING_HASH', YII_DRESSING_HASH);
        }
    }

    /**
     * Sets up the PHP environment
     */
    private function initEnvironment()
    {
        // error reporting
        if (YII_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            ini_set('log_errors', 1);
        }
        else {
            error_reporting(0);
            ini_set('display_errors', 0);
            ini_set('log_errors', 0);
        }

        // timezone
        date_default_timezone_set($this->getConfig('default_timezone', 'GMT'));

        // time and memory limit
        ini_set('max_execution_time', YII_DRESSING_CLI ? 0 : $this->getConfig('time_limit', 60));
        ini_set('memory_limit', $this->getConfig('memory_limit', "128M"));

        // cli specific
        if (YII_DRESSING_CLI) {
            // fix for fcgi
            defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
            // fix for absolute url
            $_SERVER['SERVER_NAME'] = PUBLIC_HOST;
        }

    }

}
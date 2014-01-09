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
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing
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
    private $_values = array();

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
        $this->initValues();
        $this->initConstants();
        $this->initEnvironment();
        self::$_instance = $this;
    }

    /**
     * Returns the Yii App Config
     * @return string|array
     */
    public function getAppConfig()
    {
        return self::cleanPath(dirname(VENDOR_PATH) . DS . 'app' . DS . 'config' . DS . 'main.php');
    }

    /**
     * Returns the Yii Test Config
     * @return string|array
     */
    public function getTestConfig()
    {
        return self::cleanPath(dirname(VENDOR_PATH) . DS . 'tests' . DS . '_config.php');
    }

    /**
     * Return the value of a config key
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getValue($name, $default = null)
    {
        return isset($this->_values[$name]) ? $this->_values[$name] : $default;
    }

    /**
     * Return an array of all config keys and values
     *
     * @return array
     */
    public function getValues()
    {
        return $this->_values;
    }

    /**
     * Set the value of a value key
     *
     * @param $name
     * @param $value
     */
    public function setValue($name, $value)
    {
        $this->setValues(array($name => $value));
    }

    /**
     * Set the value of all config keys and values and writes to the config file
     *
     * @param $values
     */
    public function setValues($values)
    {
        foreach ($values as $name => $value)
            if ($value !== null)
                $this->_values[$name] = $value;
            elseif (isset($this->_values[$name]))
                unset($this->_values[$name]);
        file_put_contents($this->file, json_encode($this->_values));
    }

    /**
     * Load data from config file into the value array.
     */
    protected function initValues()
    {
        // return existing object
        if ($this->_values)
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
            if (!file_put_contents($this->file, json_encode($this->_values)))
                throw new Exception(strtr('Could not create file for {class}.', array(
                    '{class}' => get_class($this),
                )));

        $this->_values = json_decode(file_get_contents($this->file), true);
    }

    /**
     * Defines any constant that has not yet been defined.
     */
    protected function initConstants()
    {
        $constants = array(
            'DS',
            'VENDOR_PATH',
            'YII_DEBUG',
            'YII_TRACE_LEVEL',
            'YII_ENABLE_EXCEPTION_HANDLER',
            'YII_ENABLE_ERROR_HANDLER',
            'YII_DRESSING_CLI',
            'YII_DRESSING_HASH',
            'WWW_PATH',
            'WWW_HOST',
            'WWW_URL',
        );
        foreach ($constants as $name)
            if (!defined($name) && ($value = $this->getValue($name)) !== null)
                define($name, $value);

        // bools and strings
        defined('YII_DEBUG') or define('YII_DEBUG', false);
        defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', YII_DEBUG);
        defined('YII_ENABLE_EXCEPTION_HANDLER') or define('YII_ENABLE_EXCEPTION_HANDLER', true);
        defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER', true);
        defined('YII_DRESSING_CLI') or define('YII_DRESSING_CLI', (substr(php_sapi_name(), 0, 3) == 'cli'));
        //defined('YII_DRESSING_LOG_LEVELS') or define('YII_DRESSING_LOG_LEVELS', 'error, warning');

        // paths
        defined('DS') or define('DS', DIRECTORY_SEPARATOR);
        defined('VENDOR_PATH') or define('VENDOR_PATH', self::cleanPath(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DS . 'vendor'));
        defined('WWW_PATH') or define('WWW_PATH', self::cleanPath(dirname(VENDOR_PATH) . DS . 'public'));

        // www_host and www_url are saved into config when accessed via web so that the value is available for cli
        if (!defined('WWW_HOST')) {
            define('WWW_HOST', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
            if (!YII_DRESSING_CLI)
                $this->setValue('WWW_HOST', WWW_HOST);
        }
        if (!defined('WWW_URL')) {
            $url = isset($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : '';
            if ($url == '/')
                $url = '';
            define('WWW_URL', $url);
            if (!YII_DRESSING_CLI)
                $this->setValue('WWW_URL', WWW_URL);
        }

        // hash needs to be defined once and saved into config so that it does not change
        if (!defined('YII_DRESSING_HASH')) {
            define('YII_DRESSING_HASH', md5(uniqid(true)));
            $this->setValue('YII_DRESSING_HASH', YII_DRESSING_HASH);
        }
    }

    /**
     * Sets up the PHP environment
     */
    protected function initEnvironment()
    {
        // error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ini_set('log_errors', 0);

        // timezone
        date_default_timezone_set($this->getValue('default_timezone', 'GMT'));

        // time and memory limit
        ini_set('max_execution_time', YII_DRESSING_CLI ? 0 : $this->getValue('time_limit', 60));
        ini_set('memory_limit', $this->getValue('memory_limit', "128M"));

        // cli specific
        if (YII_DRESSING_CLI) {
            // fix for fcgi
            defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
            // fix for absolute url
            $_SERVER['SERVER_NAME'] = WWW_HOST;
        }

    }

    /**
     * Prepares a path for the correct environment by converting back or forwardslashes to the OS prefered slash.
     *
     * @param $path
     * @return mixed
     */
    public static function cleanPath($path)
    {
        return str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, $path);
    }

}
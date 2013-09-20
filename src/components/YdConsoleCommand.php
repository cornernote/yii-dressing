<?php

/**
 *
 */
class YdConsoleCommand extends CConsoleCommand
{
    /**
     * @var array
     */
    private static $_instances = array();

    /**
     * @var
     */
    private $timer;

    /**
     * @static
     * @param string $class
     * @return ConsoleCommand
     */
    public static function instance($class = __CLASS__)
    {
        if (isset(self::$_instances[$class]))
            return self::$_instances[$class];
        else
            return self::$_instances[$class] = new $class(null, null);
    }

    /**
     *
     */
    public function init()
    {
        $this->timer = microtime(true);
        parent::init();
    }


    /**
     * @param $i
     * @param $count
     * @return string
     */
    protected function runStats($i, $count)
    {
        $stats = '';
        $stats .= '[mem=' . number_format(memory_get_peak_usage() / 1024 / 1024, 1) . '|' . number_format(memory_get_usage() / 1024 / 1024, 1) . ']';
        $stats .= '[time=' . number_format((microtime(true) - $this->timer), 1) . ']';
        $stats .= '[done=' . floor($i / $count * 100) . '%|' . $i . '/' . $count . ']';
        return $stats . ' ';
    }

}
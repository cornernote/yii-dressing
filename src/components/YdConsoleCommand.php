<?php

/**
 * YdConsoleCommand
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.components
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
     * @param string $class
     * @return ErrorEmailCommand
     */

    /**
     * Returns the static instance of the specified CC class. The object returned is a static instance of the CC class.
     * It is provided for invoking class-level methods (something similar to static class methods.)
     *
     * EVERY derived CC class must override this method as follows:
     * <pre>
     * public static function instance($class=__CLASS__) {
     *     return parent::instance($class);
     * }
     * </pre>
     *
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
        $this->timer = YII_BEGIN_TIME;
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

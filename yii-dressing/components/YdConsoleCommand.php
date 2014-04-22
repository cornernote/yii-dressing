<?php

/**
 * YdConsoleCommand
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
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
     * Returns the static instance of the specified CC class. The object returned is a static instance of the CC class.
     * It is provided for invoking class-level methods (something similar to static class methods.)
     *
     * @param string $className
     * @return YdConsoleCommand
     */
    public static function instance($className = null)
    {
        if (!$className)
            $className = get_called_class();
        if (isset(self::$_instances[$className]))
            return self::$_instances[$className];
        else
            return self::$_instances[$className] = new $className(null, null);
    }

    /**
     * @param int|null $i
     * @param int|null $count
     * @return string
     */
    protected function runStats($i = null, $count = null)
    {
        $stats = '';
        $stats .= '[mem=' . number_format(memory_get_peak_usage() / 1024 / 1024, 1) . '|' . number_format(memory_get_usage() / 1024 / 1024, 1) . ']';
        $stats .= '[time=' . number_format((microtime(true) - YII_BEGIN_TIME), 1) . ']';
        if ($i && $count) {
            $stats .= '[done=' . floor($i / $count * 100) . '%|' . $i . '/' . $count . ']';
        }
        return $stats . ' ';
    }

}

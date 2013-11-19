<?php
/**
 * ErrorEmailCommand
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.commands
 */
class ErrorEmailCommand extends YdConsoleCommand
{

    /**
     * @param string $class
     * @return ErrorEmailCommand
     */
    public static function instance($class = __CLASS__)
    {
        return parent::instance($class);
    }

    /**
     *
     */
    public function actionIndex()
    {
        $archived = 0;
        $dir = app()->getRuntimePath() . '/errors';
        foreach (glob($dir . '/' . '*.html') as $error) {
            $archive = str_replace('runtime/errors/', 'runtime/errors/archive/', $error);
            if (!file_exists(dirname($archive))) mkdir(dirname($archive), 0777, true);
            rename($error, $archive);
            $archived++;
        }
        if ($archived) {
            foreach (explode(',', Config::setting('error_email')) as $to) {
                Yii::app()->email->sendEmail(trim($to), Yii::t('dressing', 'errors have been archived'), Yii::app()->createAbsoluteUrl('/error/index'));
            }
        }
    }

}

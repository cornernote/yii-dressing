<?php
/**
 * YdErrorEmailCommand will email errors that have been generated into the error runtime folder.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.commands
 */
class YdErrorEmailCommand extends YdConsoleCommand
{

    /**
     * @var string comma separated list of email addresses
     */
    public $email;

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
        if ($archived && $this->email)
            foreach (explode(',', $this->email) as $to)
                Yii::app()->email->sendEmail(trim($to), Yii::t('dressing', 'errors have been archived'), Yii::app()->createAbsoluteUrl('/error/index'));
    }

}

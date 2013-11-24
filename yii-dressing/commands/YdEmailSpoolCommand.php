<?php
/**
 * YdEmailSpoolCommand will send emails that are pending in the spool.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.commands
 */
class YdEmailSpoolCommand extends YdConsoleCommand
{

    /**
     * @param string $class
     * @return EmailSpoolCommand
     */
    public static function instance($class = __CLASS__)
    {
        return parent::instance($class);
    }

    /**
     * SEND TO MAILINATOR.COM
     */
    public function actionIndex()
    {
        // short loop
        set_time_limit(60 * 60);
        for ($i = 0; $i < 60 * 5; $i++) {
            Yii::app()->email->processSpool($mailinator = true);
            sleep(10);
        }
    }

    /**
     * SEND LIVE EMAILS
     */
    public function actionLive()
    {
        // long loop
        set_time_limit(60 * 60 * 24);
        for ($i = 0; $i < 60 * 60; $i++) {
            Yii::app()->email->processSpool();
            sleep(1);
        }
    }

}

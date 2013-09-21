<?php
/**
 *
 */
class EmailSpoolCommand extends YdConsoleCommand
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
            EmailSpool::spool(true);
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
            EmailSpool::spool();
            sleep(1);
        }
    }

}

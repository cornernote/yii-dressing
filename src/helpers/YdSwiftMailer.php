<?php
/**
 * Swift Mailer wrapper class.
 *
 * @author Martin Nilsson <martin.nilsson@haxtech.se>
 * @link http://www.haxtech.se
 * @copyright Copyright 2010 Haxtech
 * @license GNU GPL
 */
class YdSwiftMailer
{

    /**
     *
     */
    public function init()
    {
        require_once(Yii::getPathOfAlias('vendor') . DIRECTORY_SEPARATOR . '/swiftmailer/swiftmailer/lib/swift_required.php');
    }

    /**
     * @return mixed
     */
    public function preferences()
    {
        return Swift_Preferences;
    }

    /**
     * @return mixed
     */
    public function attachment()
    {
        return Swift_Attachment;
    }

    /**
     * @param $subject
     * @return mixed
     */
    public function newMessage($subject)
    {
        return Swift_Message::newInstance($subject);
    }

    /**
     * @param null $transport
     * @return mixed
     */
    public function mailer($transport = null)
    {
        return Swift_Mailer::newInstance($transport);
    }

    /**
     * @return mixed
     */
    public function image()
    {
        return Swift_Image;
    }

    /**
     * @param null $host
     * @param null $port
     * @return mixed
     */
    public function smtpTransport($host = null, $port = null)
    {
        return Swift_SmtpTransport::newInstance($host, $port);
    }

    /**
     * @param null $command
     * @return mixed
     */
    public function sendmailTransport($command = null)
    {
        return Swift_SendmailTransport::newInstance($command);
    }

    /**
     * @return mixed
     */
    public function mailTransport()
    {
        return Swift_MailTransport::newInstance();
    }


}
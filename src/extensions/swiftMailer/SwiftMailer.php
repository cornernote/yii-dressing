<?php
/**
 * Swift Mailer wrapper class.
 *
 * @author Martin Nilsson <martin.nilsson@haxtech.se>
 * @link http://www.haxtech.se
 * @copyright Copyright 2010 Haxtech
 * @license GNU GPL
 */
class SwiftMailer
{

    public function init()
    {
        require_once(bp() . '/../../vendors/swiftMailer/Swift-4.2.1/lib/swift_required.php');
        //require_once(bp() . '/../../vendors/swiftMailer/Swift-4.2.1/lib/classes/Swift.php');
        //debug(bp() . '/../../vendors/swiftMailer/Swift-4.2.1/lib/swift_required.php');
    }

    /* Helpers */
    public function preferences()
    {
        return Swift_Preferences;
    }

    public function attachment()
    {
        return Swift_Attachment;
    }

    public function newMessage($subject)
    {
        return Swift_Message::newInstance($subject);
    }

    public function mailer($transport = null)
    {
        return Swift_Mailer::newInstance($transport);
    }

    public function image()
    {
        return Swift_Image;
    }

    public function smtpTransport($host = null, $port = null)
    {
        return Swift_SmtpTransport::newInstance($host, $port);
    }

    public function sendmailTransport($command = null)
    {
        return Swift_SendmailTransport::newInstance($command);
    }

    public function mailTransport()
    {
        return Swift_MailTransport::newInstance();
    }


}
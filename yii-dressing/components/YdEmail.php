<?php
/**
 * YdEmail
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdEmail
{

    /**
     * @param $user User
     * @return bool
     */
    public static function sendAccountRecover($user)
    {
        $emailManager = Yii::app()->emailManager;

        // get recovery temp login link
        $token = Yii::app()->tokenManager->createToken(strtotime('+1day'), 'AccountRecover', $user->primaryKey, 1);
        $url = Yii::app()->createAbsoluteUrl('/account/passwordReset', array('id' => $user->primaryKey, 'token' => $token));

        // build the templates
        $template = 'account_recover';
        $message = $emailManager->buildTemplateMessage($template, array(
            'user' => $user,
            'url' => $url,
        ));

        // get the message
        $swiftMessage = Swift_Message::newInstance($message['subject']);
        $swiftMessage->setBody($message['message'], 'text/html');
        //$swiftMessage->addPart($message['text'], 'text/plain');
        $swiftMessage->setFrom($emailManager->fromEmail, $emailManager->fromName);
        $swiftMessage->setTo($user->email, $user->name);

        // spool the email
        $emailSpool = $emailManager->getEmailSpool($swiftMessage, $user);
        $emailSpool->priority = 10;
        $emailSpool->template = $template;
        return $emailSpool->save(false);

        // or send the email
        //return Swift_Mailer::newInstance(Swift_MailTransport::newInstance())->send($swiftMessage);
    }

    /**
     * @param $user User
     * @return bool
     */
    public static function sendAccountWelcome($user)
    {
        $emailManager = Yii::app()->emailManager;

        // get activation token
        $token = EmailToken::model()->add('+30days', 1, 'ActivateRecover', $user->primaryKey);
        $url = Yii::app()->createAbsoluteUrl('/account/activate', array('id' => $user->primaryKey, 'token' => $token));

        // build the templates
        $template = 'account_welcome';
        $message = $emailManager->buildTemplateMessage($template, array(
            'user' => $user,
            'url' => $url,
        ));

        // get the message
        $swiftMessage = Swift_Message::newInstance($message['subject']);
        $swiftMessage->setBody($message['message'], 'text/html');
        //$swiftMessage->addPart($message['text'], 'text/plain');
        $swiftMessage->setFrom($emailManager->fromEmail, $emailManager->fromName);
        $swiftMessage->setTo($user->email, $user->name);

        // spool the email
        $emailSpool = $emailManager->getEmailSpool($swiftMessage, $user);
        $emailSpool->priority = 5;
        $emailSpool->template = $template;
        return $emailSpool->save(false);

        // or send the email
        //return Swift_Mailer::newInstance(Swift_MailTransport::newInstance())->send($swiftMessage);
    }

}

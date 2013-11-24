<?php
/**
 * YdEmail
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.components
 */
class YdEmail extends CApplicationComponent
{

    /**
     * @var string defaults to the application name
     */
    public $fromName;

    /**
     * @var string
     */
    public $fromEmail = 'webmaster@localhost';

    /**
     * @var bool True if sent emails should be displayed as flash messages
     */
    public $enableUserFlash;

    /**
     * @var string Render method, can be one of: php, database
     */
    public $renderMethod = 'php';

    /**
     *
     */
    public function init()
    {
        if (!$this->fromName)
            $this->fromName = Yii::app()->name;
    }

    /**
     * Allows sending a quick email.
     *
     * Eg:
     * Yii::app()->email->sendEmail('webmaster@localhost', 'test', 'hello world');
     *
     * @param $to_email
     * @param $subject
     * @param $message_text
     * @param $filename
     */
    public function sendEmail($to_email, $subject, $message_text, $filename = null)
    {
        $emailSpool = $this->getEmailSpool(array(
            'message_subject' => $subject,
            'message_text' => $message_text,
            'message_html' => Yii::app()->format->formatNtext($message_text),
        ));
        $emailSpool->status = $filename ? 'attaching' : 'pending';
        $emailSpool->from_email = $this->fromEmail;
        $emailSpool->from_name = $this->fromName;
        $emailSpool->to_email = $to_email;
        $emailSpool->save(false);

        if ($filename) {
            $attachment = new YdAttachment();
            $attachment->model = 'EmailSpool';
            $attachment->model_id = $emailSpool->id;
            $attachment->filename = $filename;
            $attachment->handleFileUpload = false;

            $emailSpool->status = 'pending';
            $emailSpool->save(false);
        }
    }

    /**
     * @param $user YdUser
     */
    public function sendAccountRecover($user)
    {
        // get recovery temp login link
        $token = YdToken::model()->add('+1day', 1, $relation);
        $url = Yii::app()->createAbsoluteUrl('/account/passwordReset', array('id' => $user->id, 'token' => $token));

        // save EmailSpool
        $emailSpool = $this->getEmailSpool($this->renderEmailTemplate('account.recover', array(
            'user' => $user,
            'url' => $url,
        )));
        $emailSpool->priority = 10;
        $emailSpool->to_email = $user->email;
        $emailSpool->to_name = $user->name;
        $emailSpool->from_email = $this->fromEmail;
        $emailSpool->from_name = $this->fromName;
        $emailSpool->model = get_class($user);
        $emailSpool->model_id = $user->id;
        $emailSpool->save(false);
    }

    /**
     * @param $user YdUser
     */
    public function sendAccountWelcome($user)
    {
        // get activation token
        $token = YdToken::model()->add('+30days', 1, $relation);
        $url = Yii::app()->createAbsoluteUrl('/account/activate', array('id' => $user->id, 'token' => $token));

        // save EmailSpool
        $emailSpool = $this->getEmailSpool($this->renderEmailTemplate('account.welcome', array(
            'user' => $user,
            'url' => $url,
        )));
        $emailSpool->priority = 5;
        $emailSpool->to_email = $user->email;
        $emailSpool->to_name = $user->name;
        $emailSpool->from_email = $this->fromEmail;
        $emailSpool->from_name = $this->fromName;
        $emailSpool->model = get_class($user);
        $emailSpool->model_id = $user->id;
        $emailSpool->save(false);
    }

    /**
     * @param array $message
     * @return YdEmailSpool
     */
    public function getEmailSpool($message)
    {
        $emailSpool = new YdEmailSpool;
        $emailSpool->status = 'pending';
        $emailSpool->template = vd($message['template']);
        $emailSpool->message_subject = $message['message_subject'];
        $emailSpool->message_text = $message['message_text'];
        $emailSpool->message_html = $message['message_html'];
        return $emailSpool;
    }

    /**
     * @param $template string
     * @param $viewParams array
     * @return array
     */
    public function renderEmailTemplate($template, $viewParams = array(), $layout = 'layout.default')
    {
        if (!method_exists($this, 'renderEmailTemplate_' . $this->renderMethod))
            $this->renderMethod = 'php';
        return call_user_func_array(array($this, 'renderEmailTemplate_' . $this->renderMethod), array($template, $viewParams, $layout));
    }

    /**
     * @param $template string
     * @param $viewParams array
     * @throws CException
     * @return array
     */
    private function renderEmailTemplate_php($template, $viewParams = array(), $layout = 'layout.default')
    {
        // setup path to layout and template
        $this->templatePath = 'dressing.views.email';
        $emailTemplate = $this->templatePath . '.' . $template;
        $emailLayout = $this->templatePath . '.' . $layout;

        // parse template
        $fields = array('message_title', 'message_subject', 'message_html', 'message_text');
        $message = array('template' => $template);
        foreach ($fields as $field) {
            $viewParams['contents'] = $controller->renderPartial($emailTemplate . '.' . $field, $viewParams, true);
            $viewParams[$field] = $message[$field] = $controller->renderPartial($emailLayout . '.' . $field, $viewParams, true);
            unset($viewParams['contents']);
        }
        return $message;
    }

    /**
     * @param $template string
     * @param $viewParams array
     * @throws CException
     * @return array
     */
    private function renderEmailTemplate_database($template, $viewParams = array(), $layout = 'layout.default')
    {
        // load template
        $emailTemplate = YdEmailTemplate::model()->findByAttributes(array('name' => $template));
        if (!$emailTemplate)
            throw new CException('missing EmailTemplate - ' . $template);

        // load layout
        $emailLayout = YdEmailTemplate::model()->findByAttributes(array('name' => $layout));
        if (!$emailLayout)
            throw new CException('missing EmailTemplate - ' . $layout);

        // parse template
        $mustache = new YdMustache();
        $fields = array('message_title', 'message_subject', 'message_html', 'message_text');
        $message = array('template' => $template);
        foreach ($fields as $field) {
            $viewParams['contents'] = $mustache->render($emailTemplate->$field, $viewParams);
            $viewParams[$field] = $message[$field] = $mustache->render($emailLayout->$field, $viewParams);
            unset($viewParams['contents']);
        }
        return $message;
    }

    /**
     * @param $emailSpool
     */
    public function userFlash($emailSpool)
    {
        if (!$this->enableUserFlash)
            return;
        if (!Yii::app()->user->checkAccess('admin'))
            return;
        if (!isset(Yii::app()->controller))
            return;

        $debug = Yii::app()->controller->renderPartial('dressing.views.email.debug', $emailSpool, true);
        Yii::app()->user->addFlash($debug, 'email');
    }


    /**
     * Find pending emails and attempt to deliver them
     * @param bool $mailinator
     */
    public function processSpool($mailinator = false)
    {
        // find all the spooled emails
        $spools = YdEmailSpool::model()->findAll(array(
            'condition' => 't.status=:status',
            'params' => array(':status' => 'pending'),
            'order' => 't.priority DESC, t.id ASC',
            'limit' => '10',
        ));
        foreach ($spools as $spool) {

            // update status to emailing
            $spool->status = 'processing';
            $spool->save(false);

            // get the to_email
            $to_email = $mailinator ? str_replace('@', '.', $spool->to_email) . '@mailinator.com' : $spool->to_email;

            // build the message
            $SM = app()->swiftMailer;
            $message = $SM->newMessage($spool->message_subject);
            $message->setFrom($spool->from_name ? array($spool->from_email => $spool->from_name) : array($spool->from_email));
            $message->setTo($spool->to_name ? array($to_email => $spool->to_name) : array($to_email));
            $message->setBody($spool->message_text);
            $message->addPart($spool->message_html, 'text/html');
            foreach ($spool->attachment as $attachment) {
                $message->attach(Swift_Attachment::fromPath($attachment->filename));
            }

            // send the email and update status
            $Transport = $SM->mailTransport();
            $Mailer = $SM->mailer($Transport);
            if ($Mailer->send($message)) {
                $spool->status = 'emailed';
                $spool->sent = date('Y-m-d H:i:s');
            }
            else {
                $spool->status = 'error';
            }
            $spool->save(false);

        }
    }

}
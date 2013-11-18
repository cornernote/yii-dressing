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
 * @package dressing.helpers
 */
class YdEmail extends CApplicationComponent
{

    /**
     * @param $user User
     */
    public function sendUserRecover($user)
    {
        // get recovery temp login link
        $token = YdToken::model()->add('+1day', 1, $relation);
        $url = Yii::app()->createAbsoluteUrl('/account/passwordReset', array('id' => $user->id, 'token' => $token));

        // save EmailSpool
        $emailSpool = $this->getEmailSpool($this->renderEmailTemplate('UserRecover', array(
            'User' => $user,
            'url' => $url,
        )));
        $emailSpool->to_email = $user->email;
        $emailSpool->to_name = $user->name;
        $emailSpool->from_email = YdConfig::setting('email');
        $emailSpool->from_name = app()->name;
        $emailSpool->model = 'User';
        $emailSpool->model_id = $user->id;
        $emailSpool->save(false);
    }

    /**
     * @param $user User
     */
    public function sendUserWelcome($user)
    {
        // get activation token
        $token = YdToken::model()->add('+30days', 1, $relation);
        $url = Yii::app()->createAbsoluteUrl('/account/activate', array('id' => $user->id, 'token' => $token));

        // save EmailSpool
        $emailSpool = $this->getEmailSpool($this->renderEmailTemplate('UserWelcome', array(
            'User' => $user,
            'url' => $url,
        )));
        $emailSpool->to_email = $user->email;
        $emailSpool->to_name = $user->name;
        $emailSpool->from_email = YdConfig::setting('email');
        $emailSpool->from_name = app()->name;
        $emailSpool->model = 'User';
        $emailSpool->model_id = $user->id;
        $emailSpool->save(false);
    }

    /**
     * @param $count int
     */
    public function sendError($count)
    {
        $url = Yii::app()->createAbsoluteUrl('/error/index');
        $messageString = Yii::t('dressing', 'errors have been archived') . ' ' . $url;

        // save EmailSpool
        foreach (explode(',', YdConfig::setting('error_email')) as $to) {
            $emailSpool = $this->getEmailSpool(array(
                'message_subject' => Yii::t('dressing', 'errors have been archived'),
                'message_text' => $messageString,
                'message_html' => format()->formatNtext($messageString),
            ));
            $emailSpool->to_email = trim($to);
            //$emailSpool->to_name = $user->name;
            $emailSpool->from_email = YdConfig::setting('email');
            $emailSpool->from_name = app()->name;
            //$emailSpool->model = 'User';
            //$emailSpool->model_id = $user->id;
            $emailSpool->save(false);
        }
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
     * @throws CException
     * @return array
     */
    public function renderEmailTemplate($template, $viewParams = array())
    {
        // load layout
        $emailLayout = YdEmailTemplate::model()->findByAttributes(array('name' => 'layout.default'));
        if (!$emailLayout)
            throw new CException('missing EmailTemplate - layout.default');

        // load template
        $emailTemplate = YdEmailTemplate::model()->findByAttributes(array('name' => $template));
        if (!$emailTemplate)
            throw new CException('missing EmailTemplate - ' . $template);

        // add settings to params
        $viewParams['Setting'] = YdConfig::settings();
        $viewParams['Setting']['bu'] = Yii::app()->createAbsoluteUrl('/');

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
        if (!YdConfig::setting('debug_email'))
            return;
        if (!Yii::app()->user->checkAccess('admin'))
            return;
        if (!isset(Yii::app()->controller))
            return;

        $debug = Yii::app()->controller->renderPartial('application.views.email._debug', $emailSpool, true);
        Yii::app()->user->addFlash($debug, 'email');
    }

}
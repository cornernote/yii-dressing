<?php
/**
 * YdEMailHelper
 */
class YdEMailHelper
{

    /**
     * @param $user User
     */
    static public function sendUserRecover($user)
    {
        // setup email variables
        $to = array($user->email => $user->name);
        $viewParams = array('User' => $user);
        $relation = array('model' => 'User', 'model_id' => $user->id, 'type' => 'UserRecover');

        // get recovery temp login link
        $token = Token::model()->add('+1day', 1, $relation);
        $viewParams['url'] = Yii::app()->createAbsoluteUrl('/account/passwordReset', array('id' => $user->id, 'token' => $token));

        // spool the email
        self::spool($to, 'user.recover', $viewParams, $relation);
    }

    /**
     * @param $user User
     */
    static public function sendUserWelcome($user)
    {
        // setup email variables
        $to = array($user->email => $user->name);
        $viewParams = array('User' => $user);
        $relation = array('model' => 'User', 'model_id' => $user->id, 'type' => 'UserWelcome');

        // get activation token
        $token = Token::model()->add('+30days', 1, $relation);
        $viewParams['url'] = Yii::app()->createAbsoluteUrl('/account/activate', array('id' => $user->id, 'token' => $token));

        // spool the email
        self::spool($to, 'user.welcome', $viewParams, $relation);
    }

    /**
     * @param $count int
     */
    static public function sendError($count)
    {
        $relation = array('model' => 'Error', 'model_id' => 0);

        $url = Yii::app()->createAbsoluteUrl('/error/index');
        $messageString = Yii::t('dressing', 'errors have been archived') . ' ' . $url;

        $message = array(
            'heading' => null,
            'subject' => Yii::t('dressing', 'errors have been archived'),
            'text' => $messageString,
            'html' => format()->formatNtext($messageString),
        );

        // email the given user
        $tos = explode(',', YdSetting::item('error_email'));
        foreach ($tos as $to) {
            $to = trim($to);
            EmailSpool::model()->spool($to, $message, $relation);
        }
    }

    /**
     * Spool (save) an email
     * @param $to string|array
     * @param $template
     * @param array $viewParams
     * @param array $relation
     * @throws CException
     * @return bool|integer
     */
    static public function spool($to, $template, $viewParams = array(), $relation = array())
    {
        // generate the message
        $message = self::renderEmailTemplate($template, $viewParams);

        // format the to_name/to_email
        $to_email = $to_name = '';
        if (!is_array($to)) {
            $to = array($to => '');
        }
        foreach ($to as $to_email => $to_name)
            break;
        if (!$to_email) {
            $to_email = $to_name;
            $to_name = '';
        }

        // save the email
        $emailSpool = new EmailSpool;
        $emailSpool->status = 'pending';
        $emailSpool->from_email = YdSetting::item('email');
        $emailSpool->from_name = app()->name;
        $emailSpool->to_email = $to_email;
        $emailSpool->to_name = $to_name;
        $emailSpool->message_subject = $message['message_subject'];
        $emailSpool->message_text = $message['message_text'];
        $emailSpool->message_html = $message['message_html'];
        if (isset($relation['model'])) {
            $emailSpool->model = $relation['model'];
            if (isset($relation['model_id'])) {
                $emailSpool->model_id = $relation['model_id'];
            }
        }
        if (isset($relation['type'])) {
            $emailSpool->type = $relation['type'];
        }

        // set flash message
        $flash = true;
        if (YdSetting::item('debug_email'))
            $flash = true;
        elseif (!Yii::app()->user->checkAccess('admin'))
            $flash = false;
        elseif (isset($options['flash']))
            $flash = $options['flash'];
        if ($flash && isset(Yii::app()->controller)) {
            $debug = Yii::app()->controller->renderPartial('application.views.email._debug', compact('to', 'message', 'template'), true);
            Yii::app()->user->addFlash($debug, 'email');
        }

        // return the id
        if ($emailSpool->save()) {
            return $emailSpool->id;
        }
        throw new CException('could not save email spool because ' . $emailSpool->getErrorString());
    }


    /**
     * @param $template string
     * @param $viewParams array
     * @throws CException
     * @return array
     */
    static public function renderEmailTemplate($template, $viewParams = array())
    {
        // load layout
        $emailLayout = EmailTemplate::model()->findByAttributes(array('name' => 'layout.default'));
        if (!$emailLayout)
            throw new CException('missing EmailTemplate - layout.default');

        // load template
        $emailTemplate = EmailTemplate::model()->findByAttributes(array('name' => $template));
        if (!$emailTemplate)
            throw new CException('missing EmailTemplate - ' . $template);

        // add settings to params
        $viewParams['Setting'] = YdSetting::items();
        $viewParams['Setting']['bu'] = Yii::app()->createAbsoluteUrl('/');

        // parse template
        $mustache = new Mustache;
        $fields = array('message_title', 'message_subject', 'message_html', 'message_text');
        $templates = array();
        foreach ($fields as $field) {
            $viewParams['contents'] = $mustache->render($emailTemplate->$field, $viewParams);
            $viewParams[$field] = $templates[$field] = $mustache->render($emailLayout->$field, $viewParams);
            unset($viewParams['contents']);
        }

        return $templates;
    }

}
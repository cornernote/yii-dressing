<?php

/**
 * YdAccountRecoverAction
 *
 * @property YdWebController $controller
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 *
 * @package dressing.actions
 */
class YdAccountRecoverAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'dressing.views.account.recover';

    /**
     * @var string
     */
    public $modelName = 'YdAccountRecover';

    /**
     * @var string
     */
    public $emailCallback = array('EEmailManager', 'sendAccountRecover');

    /**
     *
     */
    public function run()
    {
        $app = Yii::app();

        // redirect if the user is already logged in
        if ($app->user->id) {
            $this->controller->redirect($app->homeUrl);
        }

        // enable recaptcha after 3 attempts
        $attemptKey = "recover.attempt.{$_SERVER['REMOTE_ADDR']}";
        $attempts = $app->cache->get($attemptKey);
        if (!$attempts)
            $attempts = 0;
        $scenario = ($attempts >= 3 && isset($app->reCaptcha)) ? 'recaptcha' : '';

        $accountRecover = new $this->modelName($scenario);

        // collect user input data
        if (isset($_POST[$this->modelName])) {
            $accountRecover->attributes = $_POST[$this->modelName];

            if ($accountRecover->validate()) {
                $user = YdUser::model()->findbyPk($accountRecover->user_id);
                call_user_func_array($this->emailCallback, array($user)); // EEmailManager::sendAccountRecover($user);
                $app->user->addFlash(sprintf(Yii::t('dressing', 'Password reset instructions have been sent to %s. Please check your email.'), $user->email), 'success');
                $app->cache->delete($attemptKey);
                $this->controller->redirect($app->user->loginUrl);
            }
            // remove all other errors on recaptcha error
            if (isset($accountRecover->errors['recaptcha'])) {
                $errors = $accountRecover->errors['recaptcha'];
                $accountRecover->clearErrors();
                foreach ($errors as $error)
                    $accountRecover->addError('recaptcha', $error);
            }
            $app->cache->set($attemptKey, ++$attempts);

        }

        // display the recover form
        $this->controller->render($this->view, array(
            'user' => $accountRecover,
            'recaptcha' => ($attempts >= 3 && isset($app->reCaptcha)) ? true : false,
        ));
    }

}

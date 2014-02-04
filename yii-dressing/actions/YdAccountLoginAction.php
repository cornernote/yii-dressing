<?php

/**
 * YdAccountLoginAction
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
class YdAccountLoginAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'dressing.views.account.login';

    /**
     * @var string
     */
    public $formClass = 'YdAccountLogin';

    /**
     * @var string
     */
    public $userIdentityClass = 'YdUserIdentity';

    /**
     * @var bool Default setting for remember me checkbox on login page
     */
    public $defaultRememberMe = false;

    /**
     *
     */
    public function run()
    {
        $app = Yii::app();

        // redirect if the user is already logged in
        if ($app->user->id && $app->session->get('UserIdentity.web')) {
            $this->controller->redirect($app->homeUrl);
        }

        // enable recaptcha after 3 attempts
        $attemptKey = "login.attempt.{$_SERVER['REMOTE_ADDR']}";
        $attempts = $app->cache->get($attemptKey);
        if (!$attempts)
            $attempts = 0;
        $scenario = ($attempts > 3 && isset($app->reCaptcha)) ? 'recaptcha' : '';

        /** @var YdAccountLogin $user */
        $user = new $this->formClass($scenario);
        $user->userIdentityClass = $this->userIdentityClass;

        // collect user input data
        if (isset($_POST[$this->formClass])) {
            $user->attributes = $_POST[$this->formClass];

            if ($user->validate() && $user->login()) {
                $app->cache->delete($attemptKey);
                $this->controller->redirect($app->returnUrl->getUrl($app->user->returnUrl));
            }
            // remove all other errors on recaptcha error
            if (isset($user->errors['recaptcha'])) {
                $errors = $user->errors['recaptcha'];
                $user->clearErrors();
                foreach ($errors as $error)
                    $user->addError('recaptcha', $error);
            }
            $app->cache->set($attemptKey, ++$attempts);
        }
        else {
            $user->rememberMe = $this->defaultRememberMe;
        }

        // display the login form
        $this->controller->render($this->view, array(
            'user' => $user,
            'recaptcha' => ($attempts >= 3 && isset($app->reCaptcha)) ? true : false,
        ));

    }

}

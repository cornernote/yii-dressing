<?php

/**
 * AccountController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class AccountController extends WebController
{

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('login', 'register', 'recover', 'passwordReset'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('logout', 'index', 'update', 'password', 'settings'),
                'users' => array('@'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * Displays current logged in user.
     */
    public function actionIndex()
    {
        $user = $this->loadModel(user()->id, 'User');
        $this->render('view', array(
            'user' => $user,
        ));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        // redirect if the user is already logged in
        if (user()->id) {
            $this->redirect(Yii::app()->homeUrl);
        }

        // enable recaptcha after 3 attempts
        $attempts = Yii::app()->cache->get("login.attempt.{$_SERVER['REMOTE_ADDR']}");
        if (!$attempts)
            $attempts = 0;
        $scenario = ($attempts > 3 && Setting::item('recaptcha')) ? 'recaptcha' : '';

        $user = new UserLogin($scenario);

        // collect user input data
        if (isset($_POST['UserLogin'])) {
            $user->attributes = $_POST['UserLogin'];
            if ($user->validate() && $user->login()) {
                Yii::app()->cache->delete("login.attempt.{$_SERVER['REMOTE_ADDR']}");
                $this->redirect(ReturnUrl::getUrl(Yii::app()->user->returnUrl));
            }
            // remove all other errors on recaptcha error
            if (isset($user->errors['recaptcha'])) {
                $errors = $user->errors['recaptcha'];
                $user->clearErrors();
                foreach ($errors as $error)
                    $user->addError('recaptcha', $error);
            }
            Yii::app()->cache->set("login.attempt.{$_SERVER['REMOTE_ADDR']}", ++$attempts);
        }
        else {
            $user->remember_me = Setting::item('rememberMe');
        }

        // display the login form
        $this->render('login', array(
            'user' => $user,
            'recaptcha' => ($attempts >= 3 && Setting::item('recaptcha')) ? true : false,
        ));
    }


    /**
     * Displays the register page
     */
    public function actionRegister()
    {
        // redirect if the user is already logged in
        if (user()->id) {
            $this->redirect(Yii::app()->homeUrl);
        }

        $user = new UserRegister();
        $this->performAjaxValidation($user, 'register-form');

        // collect user input data
        if (isset($_POST['UserRegister'])) {
            $user->attributes = $_POST['UserRegister'];
            if ($user->save()) {
                $this->redirect(ReturnUrl::getUrl(Yii::app()->user->returnUrl));
            }
        }

        // display the register form
        $this->render('register', array(
            'user' => $user,
        ));
    }

    /**
     * User is requesting recover email
     */
    public function actionRecover()
    {
        // redirect if the user is already logged in
        if (user()->id) {
            $this->redirect(Yii::app()->homeUrl);
        }

        // enable recaptcha after 3 attempts
        $attempts = Yii::app()->cache->get("recover.attempt.{$_SERVER['REMOTE_ADDR']}");
        if (!$attempts)
            $attempts = 0;
        $scenario = ($attempts >= 3 && Setting::item('recaptcha')) ? 'recaptcha' : '';

        $userRecover = new UserRecover($scenario);
        $this->performAjaxValidation($userRecover, 'recover-form');

        // collect user input data
        if (isset($_POST['UserRecover'])) {
            $userRecover->attributes = $_POST['UserRecover'];

            if ($userRecover->validate()) {
                $user = User::model()->findbyPk($userRecover->user_id);
                email()->sendRecoverPasswordEmail($user);
                user()->addFlash(sprintf(t('Password reset instructions have been sent to %s. Please check your email.'), $user->email), 'success');
                Yii::app()->cache->delete("recover.attempt.{$_SERVER['REMOTE_ADDR']}");
                $this->redirect(array('/account/login'));
            }
            // remove all other errors on recaptcha error
            if (isset($userRecover->errors['recaptcha'])) {
                $errors = $userRecover->errors['recaptcha'];
                $userRecover->clearErrors();
                foreach ($errors as $error)
                    $userRecover->addError('recaptcha', $error);
            }
            Yii::app()->cache->set("recover.attempt.{$_SERVER['REMOTE_ADDR']}", ++$attempts);

        }
        // display the recover form
        $this->render('recover', array(
            'user' => $userRecover,
            'recaptcha' => ($attempts >= 3 && Setting::item('recaptcha')) ? true : false,
        ));
    }

    /**
     * User has clicked the email link
     * @param $id
     * @param $token
     */
    public function actionPasswordReset($id, $token)
    {
        // redirect if the user is already logged in
        if (user()->id) {
            $this->redirect(Yii::app()->homeUrl);
        }

        // redirect if they are not allowed to view this page
        $valid = true;
        $user = User::model()->findByPk($id);
        if (!$user) {
            $valid = false;
        }
        if ($valid) {
            $valid = Token::model()->checkToken('RecoverPasswordEmail', $id, $token);
        }
        if (!$valid) {
            Log::model()->add('password could not be saved due to an invalid key', array(
                'model' => 'PasswordRecover',
                'model_id' => 2,
                'details' => array(
                    'user_id' => user()->id,
                ),
            ));
            user()->addFlash(t('Invalid key.'), 'warning');
            $this->redirect(array('/account/recover'));
        }

        $userPassword = new UserPassword('recover');
        $this->performAjaxValidation($userPassword, 'password-form');
        if (isset($_POST['UserPassword'])) {
            $userPassword->attributes = $_POST['UserPassword'];
            if ($userPassword->validate()) {

                $user->password = $user->hashPassword($userPassword->password);
                if (!$user->save(false)) {
                    user()->addFlash(t('Your password could not be saved.'), 'error');
                }

                $identity = new UserIdentity($user->email, $userPassword->password);
                if ($identity->authenticate()) {
                    user()->login($identity);
                }

                Log::model()->add('password has been saved and user logged in', array(
                    'model' => 'PasswordReset',
                    'model_id' => 0,
                    'details' => array(
                        'user_id' => $user->id,
                    ),
                ));

                Token::model()->useToken('RecoverPasswordEmail', $id, $token);

                user()->addFlash(t('Your password has been saved and you have been logged in.'), 'success');
                $this->redirect(Yii::app()->homeUrl);
            }
            else {
                Log::model()->add('password could not be saved ', array(
                    'model' => 'PasswordReset',
                    'model_id' => 1,
                    'details' => array(
                        'user_id' => $user->id,
                    ),
                ));
                user()->addFlash(t('Your password could not be saved.'), 'warning');
            }
        }
        $this->render('password_reset', array('user' => $userPassword));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        user()->logout();
        $this->redirect(Yii::app()->homeUrl);

    }

    /**
     * Updates your own user details.
     */
    public function actionUpdate()
    {
        $user = $this->loadModel(user()->id, 'User');
        $user->scenario = 'account';

        $this->performAjaxValidation($user, 'account-form');

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                user()->addFlash('Your account has been saved.', 'success');
                $this->redirect(ReturnUrl::getUrl());
            }
            else {
                user()->addFlash('Your account could not be saved.', 'warning');
            }
        }

        $this->render('update', array(
            'user' => $user,
        ));
    }

    /**
     * Updates your own user password.
     */
    public function actionPassword()
    {
        /**@var $user User * */
        $user = $this->loadModel(user()->id, 'User');
        $userPassword = new UserPassword('password');
        $this->performAjaxValidation($userPassword, 'password-form');
        if (isset($_POST['UserPassword'])) {
            $userPassword->attributes = $_POST['UserPassword'];
            if ($userPassword->validate()) {
                $user->password = $user->hashPassword($userPassword->password);
                if ($user->save(false)) {
                    user()->addFlash('Your password has been saved.', 'success');
                    $this->redirect(array('/account/index'));
                }
            }
            else {
                user()->addFlash('Your password could not be saved.', 'warning');
            }
        }
        $this->render('password', array('user' => $userPassword));

    }

    /**
     * Updates your own user settings.
     */
    public function actionSettings()
    {
        /** @var $user User */
        $user = $this->loadModel(user()->id, 'User');

        if (isset($_POST['UserEav'])) {

            // check access
            $notAllowed = array();
            foreach ($notAllowed as $_notAllowed) {
                if (isset($_POST['UserEav'][$_notAllowed])) {
                    unset($_POST['UserEav'][$_notAllowed]);
                }
            }

            if ($user->setEavAttributes($_POST['UserEav'], true)) {
                user()->addFlash('Your settings have been saved.', 'success');
                $this->redirect(ReturnUrl::getUrl());
            }
            else {
                user()->addFlash('Your settings could not be saved.', 'warning');
            }
        }

        $this->render('settings', array(
            'user' => $user,
        ));
    }

}

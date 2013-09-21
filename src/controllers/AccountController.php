<?php

/**
 * AccountController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class AccountController extends YdWebController
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
                'actions' => array('login', 'signup', 'recover', 'passwordReset'),
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
        $user = $this->loadModel(Yii::app()->user->id, 'YdUser');
        $this->render('dressing.views.account.view', array(
            'user' => $user,
        ));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        // redirect if the user is already logged in
        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->homeUrl);
        }

        // enable recaptcha after 3 attempts
        $attempts = Yii::app()->cache->get("login.attempt.{$_SERVER['REMOTE_ADDR']}");
        if (!$attempts)
            $attempts = 0;
        $scenario = ($attempts > 3 && YdSetting::item('recaptcha')) ? 'recaptcha' : '';

        $user = new YdUserLogin($scenario);

        // collect user input data
        if (isset($_POST['YdUserLogin'])) {
            $user->attributes = $_POST['YdUserLogin'];
            if ($user->validate() && $user->login()) {
                Yii::app()->cache->delete("login.attempt.{$_SERVER['REMOTE_ADDR']}");
                $this->redirect(Yii::app()->returnUrl->getUrl(Yii::app()->user->returnUrl));
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
            $user->remember_me = YdSetting::item('rememberMe');
        }

        // display the login form
        $this->render('dressing.views.account.login', array(
            'user' => $user,
            'recaptcha' => ($attempts >= 3 && YdSetting::item('recaptcha')) ? true : false,
        ));
    }


    /**
     * Displays the signup page
     */
    public function actionSignup()
    {
        // redirect if the user is already logged in
        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->homeUrl);
        }

        $user = new YdUserSignup();
        $this->performAjaxValidation($user, 'signup-form');

        // collect user input data
        if (isset($_POST['UserSignup'])) {
            $user->attributes = $_POST['UserSignup'];
            if ($user->save()) {
                $this->redirect(Yii::app()->returnUrl->getUrl(Yii::app()->user->returnUrl));
            }
        }

        // display the signup form
        $this->render('dressing.views.account.signup', array(
            'user' => $user,
        ));
    }

    /**
     * User is requesting recover email
     */
    public function actionRecover()
    {
        // redirect if the user is already logged in
        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->homeUrl);
        }

        // enable recaptcha after 3 attempts
        $attempts = Yii::app()->cache->get("recover.attempt.{$_SERVER['REMOTE_ADDR']}");
        if (!$attempts)
            $attempts = 0;
        $scenario = ($attempts >= 3 && YdSetting::item('recaptcha')) ? 'recaptcha' : '';

        $userRecover = new YdUserRecover($scenario);
        $this->performAjaxValidation($userRecover, 'recover-form');

        // collect user input data
        if (isset($_POST['UserRecover'])) {
            $userRecover->attributes = $_POST['UserRecover'];

            if ($userRecover->validate()) {
                $user = User::model()->findbyPk($userRecover->user_id);
                email()->sendRecoverPasswordEmail($user);
                Yii::app()->user->addFlash(sprintf(Yii::t('dressing', 'Password reset instructions have been sent to %s. Please check your email.'), $user->email), 'success');
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
        $this->render('dressing.views.account.recover', array(
            'user' => $userRecover,
            'recaptcha' => ($attempts >= 3 && YdSetting::item('recaptcha')) ? true : false,
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
        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->homeUrl);
        }

        // redirect if they are not allowed to view this page
        $valid = true;
        $user = YdUser::model()->findByPk($id);
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
                    'user_id' => Yii::app()->user->id,
                ),
            ));
            Yii::app()->user->addFlash(Yii::t('dressing', 'Invalid key.'), 'warning');
            $this->redirect(array('/account/recover'));
        }

        $userPassword = new YdUserPassword('recover');
        $this->performAjaxValidation($userPassword, 'password-form');
        if (isset($_POST['UserPassword'])) {
            $userPassword->attributes = $_POST['UserPassword'];
            if ($userPassword->validate()) {

                $user->password = $user->hashPassword($userPassword->password);
                if (!$user->save(false)) {
                    Yii::app()->user->addFlash(Yii::t('dressing', 'Your password could not be saved.'), 'error');
                }

                $identity = new YdUserIdentity($user->email, $userPassword->password);
                if ($identity->authenticate()) {
                    Yii::app()->user->login($identity);
                }

                Log::model()->add('password has been saved and user logged in', array(
                    'model' => 'PasswordReset',
                    'model_id' => 0,
                    'details' => array(
                        'user_id' => $user->id,
                    ),
                ));

                Token::model()->useToken('RecoverPasswordEmail', $id, $token);

                Yii::app()->user->addFlash(Yii::t('dressing', 'Your password has been saved and you have been logged in.'), 'success');
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
                Yii::app()->user->addFlash(Yii::t('dressing', 'Your password could not be saved.'), 'warning');
            }
        }
        $this->render('dressing.views.account.password_reset', array('user' => $userPassword));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Updates your own user details.
     */
    public function actionUpdate()
    {
        $user = $this->loadModel(Yii::app()->user->id, 'YdUser');
        $user->scenario = 'account';

        $this->performAjaxValidation($user, 'account-form');

        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                Yii::app()->user->addFlash('Your account has been saved.', 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl());
            }
            else {
                Yii::app()->user->addFlash('Your account could not be saved.', 'warning');
            }
        }

        $this->render('dressing.views.account.update', array(
            'user' => $user,
        ));
    }

    /**
     * Updates your own user password.
     */
    public function actionPassword()
    {
        /**@var $user User * */
        $user = $this->loadModel(Yii::app()->user->id, 'YdUser');
        $userPassword = new YdUserPassword('password');
        $this->performAjaxValidation($userPassword, 'password-form');
        if (isset($_POST['UserPassword'])) {
            $userPassword->attributes = $_POST['UserPassword'];
            if ($userPassword->validate()) {
                $user->password = $user->hashPassword($userPassword->password);
                if ($user->save(false)) {
                    Yii::app()->user->addFlash('Your password has been saved.', 'success');
                    $this->redirect(array('/account/index'));
                }
            }
            else {
                Yii::app()->user->addFlash('Your password could not be saved.', 'warning');
            }
        }
        $this->render('dressing.views.account.password', array('user' => $userPassword));

    }

    /**
     * Updates your own user settings.
     */
    public function actionSettings()
    {
        /** @var $user User */
        $user = $this->loadModel(Yii::app()->user->id, 'YdUser');

        if (isset($_POST['UserEav'])) {

            // check access
            $notAllowed = array();
            foreach ($notAllowed as $_notAllowed) {
                if (isset($_POST['UserEav'][$_notAllowed])) {
                    unset($_POST['UserEav'][$_notAllowed]);
                }
            }

            if ($user->setEavAttributes($_POST['UserEav'], true)) {
                Yii::app()->user->addFlash('Your settings have been saved.', 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl());
            }
            else {
                Yii::app()->user->addFlash('Your settings could not be saved.', 'warning');
            }
        }

        $this->render('dressing.views.account.settings', array(
            'user' => $user,
        ));
    }

}

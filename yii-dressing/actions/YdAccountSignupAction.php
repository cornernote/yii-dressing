<?php

/**
 * YdAccountSignupAction
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
class YdAccountSignupAction extends CAction
{
    /**
     * @var string
     */
    public $view = 'dressing.views.account.recover';

    /**
     * @var string
     */
    public $modelName = 'YdAccountSignup';

    /**
     * @var
     */
    public $userClass = 'YdUser';

    /**
     * @var
     */
    public $userIdentityClass = 'YdUserIdentity';

    /**
     * @var array
     */
    public $emailCallback = array('EEmailManager', 'sendAccountSignup');

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

        /** @var YdAccountSignup $accountSignup */
        $accountSignup = new $this->modelName();
        $accountSignup->userClass = $this->userClass;
        $accountSignup->userIdentityClass = $this->userIdentityClass;

        // collect user input data
        if (isset($_POST[$this->modelName])) {
            $accountSignup->attributes = $_POST[$this->modelName];
            if ($accountSignup->save()) {
                call_user_func_array($this->emailCallback, array($accountSignup->user)); // EEmailManager::sendAccountSignup($accountSignup->user);
                $this->controller->redirect($app->returnUrl->getUrl($app->user->returnUrl));
            }
        }

        // display the signup form
        $this->controller->render($this->view, array(
            'accountSignup' => $accountSignup,
        ));

    }

}

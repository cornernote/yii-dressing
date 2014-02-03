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

        /** @var YdAccountSignup $user */
        $user = new $this->modelName();
        $user->userIdentityClass = $this->userIdentityClass;

        // collect user input data
        if (isset($_POST[$this->modelName])) {
            $user->attributes = $_POST[$this->modelName];
            if ($user->save()) {
                call_user_func_array($this->emailCallback, array($user)); // EEmailManager::sendAccountSignup($user);
                $this->controller->redirect($app->returnUrl->getUrl($app->user->returnUrl));
            }
        }

        // display the signup form
        $this->controller->render($this->view, array(
            'user' => $user,
        ));

    }

}

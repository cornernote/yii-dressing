<?php

/**
 * YdAccountPasswordResetAction
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
class YdAccountPasswordResetAction extends CAction
{

    /**
     * @var string
     */
    public $view = 'dressing.views.account.password_reset';

    /**
     * @var string
     */
    public $modelName = 'YdAccountPassword';

    /**
     * @var string
     */
    public $userModelName = 'YdUser';

    /**
     * @var string
     */
    public $userIdentityClass = 'YdUserIdentity';

    /**
     * User clicked a link, check if it's valid and allow them to reset their password
     *
     * @param $id
     * @param $token
     */
    public function run($id, $token)
    {
        $app = Yii::app();

        // redirect if the user is already logged in
        if ($app->user->id) {
            $this->controller->redirect($app->homeUrl);
        }

        // redirect if the key is invalid
        $valid = true;
        $user = CActiveRecord::model($userModelName)->findByPk($id);
        if (!$user) {
            $valid = false;
        }
        if ($valid) {
            $valid = YdToken::model()->checkToken('RecoverPasswordEmail', $id, $token);
        }
        if (!$valid) {
            $app->user->addFlash(Yii::t('dressing', 'Invalid key.'), 'warning');
            $this->controller->redirect($app->user->loginUrl);
        }

        $accountPassword = new $this->modelName('recover');
        if ($this->userModelName && isset($accountPassword->userModelName))
            $accountPassword->userModelName = $this->userModelName;
        if (isset($_POST[$this->modelName])) {
            $accountPassword->attributes = $_POST[$this->modelName];
            if ($accountPassword->validate()) {

                $user->password = $user->hashPassword($accountPassword->new_password);
                if (!$user->save(false)) {
                    $app->user->addFlash(Yii::t('dressing', 'Your password could not be saved.'), 'error');
                }

                $identity = new $this->userIdentityClass($user->email, $accountPassword->new_password);
                if ($identity->authenticate()) {
                    $app->user->login($identity);
                }

                YdToken::model()->useToken('RecoverPasswordEmail', $id, $token);

                $app->user->addFlash(Yii::t('dressing', 'Your password has been saved and you have been logged in.'), 'success');
                $this->controller->redirect($app->homeUrl);
            }
            else {
                $app->user->addFlash(Yii::t('dressing', 'Your password could not be saved.'), 'warning');
            }
        }
        $this->render($this->view, array(
            'user' => $accountPassword,
        ));
    }

}

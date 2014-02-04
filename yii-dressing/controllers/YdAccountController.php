<?php

/**
 * YdAccountController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.controllers
 */
class YdAccountController extends YdWebController
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
                'actions' => array('login', 'lostPassword', 'resetPassword'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('signup'),
                'users' => array('?'),
            ),
            array('allow',
                'actions' => array('logout', 'index', 'update', 'password', 'settings'),
                'users' => array('@'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'signup' => array(
                'class' => 'dressing.actions.YdAccountSignupAction',
            ),
            'login' => array(
                'class' => 'dressing.actions.YdAccountLoginAction',
            ),
            'logout' => array(
                'class' => 'dressing.actions.YdAccountLogoutAction',
            ),
            'lostPassword' => array(
                'class' => 'dressing.actions.YdAccountLostPasswordAction',
            ),
            'resetPassword' => array(
                'class' => 'dressing.actions.YdAccountResetPasswordAction',
            ),
        );
    }

    /**
     * @param string $view the view to be rendered
     * @return bool
     */
    public function beforeRender($view)
    {
        $this->pageTitle = $this->pageHeading = Yii::t('dressing', 'My Account');
        //if ($view != 'login')
        //    $this->menu = SiteMenu::getItemsFromMenu(SiteMenu::MENU_USER);
        return parent::beforeRender($view);
    }

    /**
     * Displays current logged in user.
     */
    public function actionIndex()
    {
        $user = $this->loadModel(Yii::app()->user->id, 'YdUser');
        $this->render('view', array(
            'user' => $user,
        ));
    }

    /**
     * Updates your own user details.
     */
    public function actionUpdate()
    {
        $user = $this->loadModel(Yii::app()->user->id, 'YdUser');
        $user->scenario = 'account';

        if (isset($_POST['YdUser'])) {
            $user->attributes = $_POST['YdUser'];
            if ($user->save()) {
                Yii::app()->user->addFlash('Your account has been saved.', 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl(array('/account/index')));
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
        $user = $this->loadModel(Yii::app()->user->id, 'YdUser');
        $accountPassword = new YdAccountPassword('password');
        if (isset($_POST['YdAccountPassword'])) {
            $accountPassword->attributes = $_POST['YdAccountPassword'];
            if ($accountPassword->validate()) {
                $user->password = $user->hashPassword($accountPassword->password);
                if ($user->save(false)) {
                    Yii::app()->user->addFlash('Your password has been saved.', 'success');
                    $this->redirect(array('/account/index'));
                }
            }
        }
        $this->render('password', array('user' => $accountPassword));

    }

    /**
     * Updates your own user settings.
     */
    public function actionSettings()
    {
        $user = $this->loadModel(Yii::app()->user->id, 'YdUser');

        if (isset($_POST['YdUserEav'])) {

            // check access
            $notAllowed = array();
            foreach ($notAllowed as $_notAllowed) {
                if (isset($_POST['YdUserEav'][$_notAllowed])) {
                    unset($_POST['YdUserEav'][$_notAllowed]);
                }
            }

            if ($user->setEavAttributes($_POST['YdUserEav'], true)) {
                Yii::app()->user->addFlash('Your settings have been saved.', 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl());
            }
            else {
                Yii::app()->user->addFlash('Your settings could not be saved.', 'warning');
            }
        }

        $this->render('settings', array(
            'user' => $user,
        ));
    }

}

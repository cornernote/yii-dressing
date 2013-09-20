<?php

/**
 * UserController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class UserController extends WebController
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
                'actions' => array('index', 'view', 'create', 'update', 'delete', 'log'),
                'roles' => array('admin'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * List
     */
    public function actionIndex()
    {
        $user = new User('search');
        if (!empty($_GET['User']))
            $user->attributes = $_GET['User'];

        $this->render('index', array(
            'user' => $user,
        ));
    }

    /**
     * View
     * @param integer $id the ID of the user to be displayed
     * @throws CHttpException
     */
    public function actionView($id)
    {
        /** @var $user User */
        $user = $this->loadModel($id);

        // check for deleted user
        if ($user->deleted) {
            user()->addFlash('THIS USER IS DELETED', 'warning');
        }

        $this->render('view', array(
            'user' => $user,
        ));
    }

    /**
     * Log
     * @param $id
     * @throws CHttpException
     */
    public function actionLog($id)
    {
        /** @var $user User */
        $user = $this->loadModel($id, 'User');

        $this->render('log', array(
            'user' => $user,
        ));
    }

    /**
     * Create
     */
    public function actionCreate()
    {
        $user = new User('create');

        $this->performAjaxValidation($user, 'user-form');
        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                //$userToRole = new UserToRole();
                //$userToRole->user_id = $user->id;
                //$userToRole->role_id = $role->id;
                //$userToRole->save(false);
                user()->addFlash('User has been created.', 'success');
                $this->redirect(ReturnUrl::getUrl($user->getUrl()));
            }
        }
        else {
            if (isset($_GET['User'])) {
                $user->attributes = $_GET['User'];
            }
        }

        $this->render('create', array(
            'user' => $user,
        ));
    }

    /**
     * Update
     * @param integer $id the ID of the user to be updated
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        /** @var $user User */
        $user = $this->loadModel($id);

        $this->performAjaxValidation($user, 'user-form');
        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if ($user->save()) {
                user()->addFlash(t('User has been updated'), 'success');
                $this->redirect(ReturnUrl::getUrl($user->getUrl()));
            }
            user()->addFlash(t('User could not be updated'), 'warning');
        }
        else {
            //set defaults
            $user->password = null;
        }

        $this->render('update', array(
            'user' => $user,
        ));
    }

    /**
     * Deletes a particular model.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id = null)
    {
        $task = sf('task', 'User') == 'undelete' ? 'undelete' : 'delete';
        if (sf('confirm', 'User')) {
            $ids = sfGrid($id);
            foreach ($ids as $id) {
                $user = User::model()->findByPk($id);

                // check access
                if (!$user->checkUserAccess(user()->id)) {
                    continue;
                }
                call_user_func(array($user, $task));
                user()->addFlash(strtr('User :name has been :tasked.', array(
                    ':name' => $user->getName(),
                    ':tasked' => $task . 'd',
                )), 'success');
            }
            $this->redirect(ReturnUrl::getUrl(user()->getState('index.user', array('/user/index'))));
        }

        $this->render('delete', array(
            'id' => $id,
            'task' => $task,
        ));
    }

}

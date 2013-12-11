<?php

/**
 * YdUserController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.controllers
 */
class YdUserController extends YdWebController
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
     * @param string $view the view to be rendered
     * @return bool
     */
    public function beforeRender($view)
    {
        $this->addBreadcrumb(Yii::t('dressing', 'Tools'), array('/tool/index'));
        if (in_array($view, array('view', 'update', 'password'))) {
            $this->addBreadcrumb(Yii::t('dressing', 'Users'), Yii::app()->user->getState('index.user', array('/user/index')));
        }
        return parent::beforeRender($view);
    }

    /**
     * List
     */
    public function actionIndex()
    {
        $user = new YdUser('search');
        if (!empty($_GET['YdUser']))
            $user->attributes = $_GET['YdUser'];

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
        $user = $this->loadModel($id, 'YdUser');

        // check for deleted user
        if ($user->deleted) {
            Yii::app()->user->addFlash('THIS USER IS DELETED', 'warning');
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
        $user = $this->loadModel($id, 'YdUser');

        $this->render('log', array(
            'user' => $user,
        ));
    }

    /**
     * Create
     */
    public function actionCreate()
    {
        $user = new YdUser('create');

        if (isset($_POST['YdUser'])) {
            $user->attributes = $_POST['YdUser'];
            if ($user->save()) {
                //$userToRole = new YdUserToRole();
                //$userToRole->user_id = $user->id;
                //$userToRole->role_id = $role->id;
                //$userToRole->save(false);
                Yii::app()->user->addFlash('User has been created.', 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl($user->getUrl()));
            }
        }
        else {
            if (isset($_GET['YdUser'])) {
                $user->attributes = $_GET['YdUser'];
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
        /** @var $user YdUser */
        $user = $this->loadModel($id, 'YdUser');

        if (isset($_POST['YdUser'])) {
            $user->attributes = $_POST['YdUser'];
            if ($user->save()) {
                Yii::app()->user->addFlash(Yii::t('dressing', 'User has been updated'), 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl($user->getUrl()));
            }
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
        $task = YdHelper::getSubmittedField('task', 'YdUser') == 'undelete' ? 'undelete' : 'delete';
        if (YdHelper::getSubmittedField('confirm', 'YdUser')) {
            foreach (YdHelper::getGridIds($id) as $_id) {
                $user = YdUser::model()->findByPk($_id);

                // check access
                if (!$user->checkUserAccess(Yii::app()->user->id)) {
                    continue;
                }
                call_user_func(array($user, $task));
                Yii::app()->user->addFlash(strtr('User :name has been :tasked.', array(
                    ':name' => $user->getName(),
                    ':tasked' => $task . 'd',
                )), 'success');
            }
            $this->redirect(Yii::app()->returnUrl->getUrl(Yii::app()->user->getState('index.user', array('/user/index'))));
        }

        $this->render('delete', array(
            'id' => $id,
            'task' => $task,
        ));
    }

}

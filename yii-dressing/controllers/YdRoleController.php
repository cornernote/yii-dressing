<?php
/**
 * YdRoleController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.controllers
 */
class YdRoleController extends YdWebController
{

    /**
     * Access Control
     * @return array
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'log', 'create', 'update', 'delete'),
                'roles' => array('admin'),
                //'users' => array('*','@','?'), // all, user, guest
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
        if (in_array($view, array('view', 'update', 'log'))) {
            $this->addBreadcrumb(Yii::t('dressing', 'Roles'), Yii::app()->user->getState('index.role', array('/role/index')));
        }
        return parent::beforeRender($view);
    }

    /**
     * Index
     */
    public function actionIndex()
    {
        $role = new YdRole('search');
        if (!empty($_GET['YdRole']))
            $role->attributes = $_GET['YdRole'];

        $this->render('index', array(
            'role' => $role,
        ));
    }

    /**
     * View
     * @param $id
     */
    public function actionView($id)
    {
        /** @var $role YdRole */
        $role = $this->loadModel($id, 'YdRole');

        $this->render('view', array(
            'role' => $role,
        ));
    }

    /**
     * Log
     * @param $id
     */
    public function actionLog($id)
    {
        /** @var $role YdRole */
        $role = $this->loadModel($id, 'YdRole');

        $this->render('log', array(
            'role' => $role,
        ));
    }

    /**
     * Create
     */
    public function actionCreate()
    {
        $role = new YdRole('create');

        if (isset($_POST['YdRole'])) {
            $role->attributes = $_POST['YdRole'];
            if ($role->save()) {
                Yii::app()->user->addFlash(strtr('Role :name has been created.', array(':name' => $role->getName())), 'success');
                $this->redirect(ReturnUrl::getUrl($role->getUrl()));
            }
        }
        else {
            if (isset($_GET['YdRole'])) {
                $role->attributes = $_GET['YdRole'];
            }
        }

        $this->render('create', array(
            'role' => $role,
        ));
    }

    /**
     * Update
     * @param $id
     */
    public function actionUpdate($id)
    {
        /** @var $role YdRole */
        $role = $this->loadModel($id, 'YdRole');

        if (isset($_POST['YdRole'])) {
            $role->attributes = $_POST['YdRole'];
            if ($role->save()) {
                Yii::app()->user->addFlash(strtr('Role :name has been updated.', array(':name' => $role->getName())), 'success');
                $this->redirect(ReturnUrl::getUrl($role->getUrl()));
            }
        }

        $this->render('update', array(
            'role' => $role,
        ));
    }

    /**
     * Delete and Undelete
     * @param $id
     */
    public function actionDelete($id = null)
    {
        $task = YdHelper::getSubmittedField('task', 'YdRole') == 'undelete' ? 'undelete' : 'delete';
        if (YdHelper::getSubmittedField('confirm', 'YdRole')) {
            foreach (YdHelper::getGridIds($id) as $_id) {
                $role = YdRole::model()->findByPk($_id);
                if (!$role) {
                    continue;
                }
                call_user_func(array($role, $task));
                Yii::app()->user->addFlash(strtr('Role :name has been :tasked.', array(
                    ':name' => $role->getName(),
                    ':tasked' => $task . 'd',
                )), 'success');
            }
            $this->redirect(ReturnUrl::getUrl(Yii::app()->user->getState('index.role', array('/role/index'))));
        }

        $this->render('delete', array(
            'id' => $id,
            'task' => $task,
        ));
    }

}

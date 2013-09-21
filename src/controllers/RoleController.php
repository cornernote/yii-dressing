<?php
/**
 *
 */
class RoleController extends YdWebController
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
     * Index
     */
    public function actionIndex()
    {
        $role = new YdRole('search');
        if (!empty($_GET['YdRole']))
            $role->attributes = $_GET['YdRole'];

        $this->render('dressing.views.role.index', array(
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

        $this->render('dressing.views.role.view', array(
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

        $this->render('dressing.views.role.log', array(
            'role' => $role,
        ));
    }

    /**
     * Create
     */
    public function actionCreate()
    {
        $role = new YdRole('create');

        $this->performAjaxValidation($role, 'role-form');
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

        $this->render('dressing.views.role.create', array(
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

        $this->performAjaxValidation($role, 'role-form');
        if (isset($_POST['YdRole'])) {
            $role->attributes = $_POST['YdRole'];
            if ($role->save()) {
                Yii::app()->user->addFlash(strtr('Role :name has been updated.', array(':name' => $role->getName())), 'success');
                $this->redirect(ReturnUrl::getUrl($role->getUrl()));
            }
        }

        $this->render('dressing.views.role.update', array(
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
            foreach ($this->getGridIds($id) as $_id) {
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

        $this->render('dressing.views.role.delete', array(
            'id' => $id,
            'task' => $task,
        ));
    }

}

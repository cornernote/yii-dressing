<?php
/**
 * MenuController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class MenuController extends YdWebController
{

    /**
     * Access Control
     * @return array
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'log', 'create', 'update', 'delete', 'order'),
                'roles' => array('admin'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * Index
     */
    public function actionIndex()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('t.parent_id', 0);
        $menus = YdMenu::model()->findAll($criteria);
        $this->render('dressing.views.menu.index', array(
            'menus' => $menus,
        ));
    }

    /**
     * View
     * @param $id
     */
    public function actionView($id)
    {
        /** @var $menu YdMenu */
        $menu = $this->loadModel($id, 'YdMenu');

        // check for deleted YdMenu
        if ($menu->deleted) {
            Yii::app()->user->addFlash('THIS RECORD IS DELETED', 'warning');
        }

        $this->render('dressing.views.menu.view', array(
            'menu' => $menu,
        ));
    }

    /**
     * Log
     * @param $id
     */
    public function actionLog($id)
    {
        /** @var $menu YdMenu */
        $menu = $this->loadModel($id, 'YdMenu');

        $this->render('dressing.views.menu.log', array(
            'menu' => $menu,
        ));
    }

    /**
     * Create
     */
    public function actionCreate()
    {
        $menu = new YdMenu('create');

        $this->performAjaxValidation($menu, 'menu-form');
        if (isset($_POST['YdMenu'])) {
            $menu->attributes = $_POST['YdMenu'];
            if ($menu->save()) {
                Yii::app()->user->addFlash('Menu has been created.', 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl($menu->getUrl()));
            }
        }
        else {
            $menu->enabled = 1;
            if (isset($_GET['YdMenu'])) {
                $menu->attributes = $_GET['YdMenu'];
            }
        }

        $this->render('dressing.views.menu.create', array(
            'menu' => $menu,
        ));
    }

    /**
     * Update
     * @param $id
     */
    public function actionUpdate($id)
    {
        /** @var $menu YdMenu */
        $menu = $this->loadModel($id, 'YdMenu');

        $this->performAjaxValidation($menu, 'menu-form');
        if (isset($_POST['YdMenu'])) {
            $menu->attributes = $_POST['YdMenu'];
            if ($menu->save()) {
                Yii::app()->user->addFlash(Yii::t('dressing', 'Menu has been updated'), 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl($menu->getUrl()));
            }
        }

        $this->render('dressing.views.menu.update', array(
            'menu' => $menu,
        ));
    }

    /**
     * Delete
     * @param $id
     */
    public function actionDelete($id = null)
    {
        $task = YdHelper::getSubmittedField('task', 'YdMenu') == 'undelete' ? 'undelete' : 'delete';
        if (YdHelper::getSubmittedField('confirm', 'YdMenu')) {
            foreach ($this->getGridIds($id) as $_id) {
                $menu = YdMenu::model()->findByPk($_id);
                if (!$menu) {
                    continue;
                }
                call_user_func(array($menu, $task));
                Yii::app()->user->addFlash(strtr('Lookup :name has been :tasked.', array(
                    ':name' => $menu->getName(),
                    ':tasked' => $task . 'd',
                )), 'success');
            }
            $this->redirect(Yii::app()->returnUrl->getUrl(Yii::app()->user->getState('index.menu', array('/menu/index'))));
        }

        $this->render('dressing.views.menu.delete', array(
            'id' => $id,
            'task' => $task,
        ));
    }

    /**
     * Handle ordering.
     */
    public function actionOrder()
    {
        if (isset($_POST['Order'])) {
            $menus = explode(',', $_POST['Order']);
            foreach ($menus as $k => $menu_id) {
                if ($menu = YdMenu::model()->findbyPk($menu_id)) {
                    $menu->sort_order = $k;
                    $menu->save(false);
                }
            }
        }
    }


}

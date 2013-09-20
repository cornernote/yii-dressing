<?php
/**
 * MenuController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class MenuController extends WebController
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
        $menus = Menu::model()->findAll($criteria);
        $this->render('index', array(
            'menus' => $menus,
        ));
    }

    /**
     * View
     * @param $id
     */
    public function actionView($id)
    {
        /** @var $menu Menu */
        $menu = $this->loadModel($id);

        // check for deleted Menu
        if ($menu->deleted) {
            user()->addFlash('THIS RECORD IS DELETED', 'warning');
        }

        $this->render('view', array(
            'menu' => $menu,
        ));
    }

    /**
     * Log
     * @param $id
     */
    public function actionLog($id)
    {
        /** @var $menu Menu */
        $menu = $this->loadModel($id);

        $this->render('log', array(
            'menu' => $menu,
        ));
    }

    /**
     * Create
     */
    public function actionCreate()
    {
        $menu = new Menu('create');

        $this->performAjaxValidation($menu, 'menu-form');
        if (isset($_POST['Menu'])) {
            $menu->attributes = $_POST['Menu'];
            if ($menu->save()) {
                user()->addFlash('Menu has been created.', 'success');
                $this->redirect(ReturnUrl::getUrl($menu->getUrl()));
            }
        }
        else {
            $menu->enabled = 1;
            if (isset($_GET['Menu'])) {
                $menu->attributes = $_GET['Menu'];
            }
        }

        $this->render('create', array(
            'menu' => $menu,
        ));
    }

    /**
     * Update
     * @param $id
     */
    public function actionUpdate($id)
    {
        /** @var $menu Menu */
        $menu = $this->loadModel($id);

        $this->performAjaxValidation($menu, 'menu-form');
        if (isset($_POST['Menu'])) {
            $menu->attributes = $_POST['Menu'];
            if ($menu->save()) {
                user()->addFlash(t('Menu has been updated'), 'success');
                $this->redirect(ReturnUrl::getUrl($menu->getUrl()));
            }
            user()->addFlash(t('Menu could not be updated'), 'warning');
        }

        $this->render('update', array(
            'menu' => $menu,
        ));
    }

    /**
     * Delete
     * @param $id
     */
    public function actionDelete($id = null)
    {
        $task = sf('task', 'Menu') == 'undelete' ? 'undelete' : 'delete';
        if (sf('confirm', 'Menu')) {
            $ids = sfGrid($id);
            foreach ($ids as $id) {
                $menu = Menu::model()->findByPk($id);
                if (!$menu) {
                    continue;
                }
                call_user_func(array($menu, $task));
                user()->addFlash(strtr('Lookup :name has been :tasked.', array(
                    ':name' => $menu->getName(),
                    ':tasked' => $task . 'd',
                )), 'success');
            }
            $this->redirect(ReturnUrl::getUrl(user()->getState('index.menu', array('/menu/index'))));
        }

        $this->render('delete', array(
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
                if ($menu = Menu::model()->findbyPk($menu_id)) {
                    $menu->sort_order = $k;
                    $menu->save(false);
                }
            }
        }
    }


}

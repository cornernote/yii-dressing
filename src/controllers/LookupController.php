<?php
/**
 * LookupController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class LookupController extends YdWebController
{

    /**
     * Access Control
     * @return array
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'log', 'create', 'update', 'delete', 'order', 'type'),
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
        $lookup = new YdLookup('search');
        if (!empty($_GET['YdLookup']))
            $lookup->attributes = $_GET['YdLookup'];

        $this->render('dressing.views.lookup.index', array(
            'lookup' => $lookup,
        ));
    }

    /**
     * View
     * @param $id
     */
    public function actionView($id)
    {
        /** @var $lookup YdLookup */
        $lookup = $this->loadModel($id, 'YdLookup');

        // check for deleted YdLookup
        if ($lookup->deleted) {
            user()->addFlash('THIS RECORD IS DELETED', 'warning');
        }

        $this->render('dressing.views.lookup.view', array(
            'lookup' => $lookup,
        ));
    }

    /**
     * Log
     * @param $id
     */
    public function actionLog($id)
    {
        /** @var $lookup YdLookup */
        $lookup = $this->loadModel($id, 'YdLookup');

        $this->render('dressing.views.lookup.log', array(
            'lookup' => $lookup,
        ));
    }

    /**
     * Create
     */
    public function actionCreate()
    {
        $lookup = new YdLookup('create');

        $this->performAjaxValidation($lookup, 'lookup-form');
        if (isset($_POST['YdLookup'])) {
            $lookup->attributes = $_POST['YdLookup'];
            if ($lookup->save()) {
                user()->addFlash('Lookup has been created.', 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl($lookup->getUrl()));
            }
        }
        else {
            if (isset($_GET['YdLookup'])) {
                $lookup->attributes = $_GET['YdLookup'];
            }
        }

        $this->render('dressing.views.lookup.create', array(
            'lookup' => $lookup,
        ));
    }

    /**
     * Update
     * @param $id
     */
    public function actionUpdate($id)
    {
        /** @var $lookup YdLookup */
        $lookup = $this->loadModel($id, 'YdLookup');

        $this->performAjaxValidation($lookup, 'lookup-form');
        if (isset($_POST['YdLookup'])) {
            $lookup->attributes = $_POST['YdLookup'];
            if ($lookup->save()) {
                user()->addFlash(t('Lookup has been updated'), 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl($lookup->getUrl()));
            }
            user()->addFlash(t('Lookup could not be updated'), 'warning');
        }

        $this->render('dressing.views.lookup.update', array(
            'lookup' => $lookup,
        ));
    }

    /**
     * Delete
     * @param $id
     */
    public function actionDelete($id = null)
    {
        $task = sf('task', 'YdLookup') == 'undelete' ? 'undelete' : 'delete';
        if (sf('confirm', 'YdLookup')) {
            $ids = sfGrid($id);
            foreach ($ids as $id) {
                $lookup = YdLookup::model()->findByPk($id);
                if (!$lookup) {
                    continue;
                }
                call_user_func(array($lookup, $task));
                user()->addFlash(strtr('Lookup :name has been :tasked.', array(
                    ':name' => $lookup->getName(),
                    ':tasked' => $task . 'd',
                )), 'success');
            }
            $this->redirect(Yii::app()->returnUrl->getUrl(user()->getState('index.lookup', array('/lookup/index'))));
        }

        $this->render('dressing.views.lookup.delete', array(
            'id' => $id,
            'task' => $task,
        ));
    }

    /**
     * Handles the ordering of lookups.
     */
    public function actionOrder()
    {
        if (isset($_POST['Order'])) {
            $lookups = explode(',', $_POST['Order']);
            foreach ($lookups as $k => $lookup_id) {
                if ($lookup = YdLookup::model()->findbyPk($lookup_id)) {
                    $lookup->position = $k;
                    $lookup->save(false);
                }
            }
        }
    }

    /**
     * Displays a particular group of lookups.
     * @param $type
     * @param integer $id the ID of the lookup to be displayed
     */
    public function actionType($type, $id = null)
    {
        // get types
        $types = YdLookup::model()->types;

        // get lookups for sortable
        $lookups = YdLookup::model()->findAll(array(
            'condition' => 'type=:type AND deleted IS NULL',
            'params' => array(
                ':type' => $type,
            ),
            'order' => 't.position',
        ));

        // get lookup for form
        $lookup = $id ? $this->loadModel($id, 'YdLookup') : new YdLookup;
        $this->performAjaxValidation($lookup, 'lookup-form');
        if (isset($_POST['YdLookup'])) {
            if (!$id) {
                $lookup->type = $type;
            }
            $lookup->attributes = $_POST['YdLookup'];
            if ($lookup->save()) {
                user()->addFlash(t('Lookup has been saved.'), 'success');
                $this->redirect(array('lookup/view', 'type' => $type));
            }
            else {
                user()->addFlash(t('Lookup could not be saved.'), 'error');
            }
        }

        // render view
        $this->render('dressing.views.lookup.view', array(
            'types' => $types,
            'type' => $type,
            'lookups' => $lookups,
            'lookup' => $lookup,
        ));
    }

}

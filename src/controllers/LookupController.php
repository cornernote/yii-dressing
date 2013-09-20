<?php
/**
 * LookupController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class LookupController extends WebController
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
        $lookup = new Lookup('search');
        if (!empty($_GET['Lookup']))
            $lookup->attributes = $_GET['Lookup'];

        $this->render('index', array(
            'lookup' => $lookup,
        ));
    }

    /**
     * View
     * @param $id
     */
    public function actionView($id)
    {
        /** @var $lookup Lookup */
        $lookup = $this->loadModel($id);

        // check for deleted Lookup
        if ($lookup->deleted) {
            user()->addFlash('THIS RECORD IS DELETED', 'warning');
        }

        $this->render('view', array(
            'lookup' => $lookup,
        ));
    }

    /**
     * Log
     * @param $id
     */
    public function actionLog($id)
    {
        /** @var $lookup Lookup */
        $lookup = $this->loadModel($id);

        $this->render('log', array(
            'lookup' => $lookup,
        ));
    }

    /**
     * Create
     */
    public function actionCreate()
    {
        $lookup = new Lookup('create');

        $this->performAjaxValidation($lookup, 'lookup-form');
        if (isset($_POST['Lookup'])) {
            $lookup->attributes = $_POST['Lookup'];
            if ($lookup->save()) {
                user()->addFlash('Lookup has been created.', 'success');
                $this->redirect(ReturnUrl::getUrl($lookup->getUrl()));
            }
        }
        else {
            if (isset($_GET['Lookup'])) {
                $lookup->attributes = $_GET['Lookup'];
            }
        }

        $this->render('create', array(
            'lookup' => $lookup,
        ));
    }

    /**
     * Update
     * @param $id
     */
    public function actionUpdate($id)
    {
        /** @var $lookup Lookup */
        $lookup = $this->loadModel($id);

        $this->performAjaxValidation($lookup, 'lookup-form');
        if (isset($_POST['Lookup'])) {
            $lookup->attributes = $_POST['Lookup'];
            if ($lookup->save()) {
                user()->addFlash(t('Lookup has been updated'), 'success');
                $this->redirect(ReturnUrl::getUrl($lookup->getUrl()));
            }
            user()->addFlash(t('Lookup could not be updated'), 'warning');
        }

        $this->render('update', array(
            'lookup' => $lookup,
        ));
    }

    /**
     * Delete
     * @param $id
     */
    public function actionDelete($id = null)
    {
        $task = sf('task', 'Lookup') == 'undelete' ? 'undelete' : 'delete';
        if (sf('confirm', 'Lookup')) {
            $ids = sfGrid($id);
            foreach ($ids as $id) {
                $lookup = Lookup::model()->findByPk($id);
                if (!$lookup) {
                    continue;
                }
                call_user_func(array($lookup, $task));
                user()->addFlash(strtr('Lookup :name has been :tasked.', array(
                    ':name' => $lookup->getName(),
                    ':tasked' => $task . 'd',
                )), 'success');
            }
            $this->redirect(ReturnUrl::getUrl(user()->getState('index.lookup', array('/lookup/index'))));
        }

        $this->render('delete', array(
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
                if ($lookup = Lookup::model()->findbyPk($lookup_id)) {
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
        $types = Lookup::model()->types;

        // get lookups for sortable
        $lookups = Lookup::model()->findAll(array(
            'condition' => 'type=:type AND deleted IS NULL',
            'params' => array(
                ':type' => $type,
            ),
            'order' => 't.position',
        ));

        // get lookup for form
        $lookup = $id ? $this->loadModel($id) : new Lookup;
        $this->performAjaxValidation($lookup, 'lookup-form');
        if (isset($_POST['Lookup'])) {
            if (!$id) {
                $lookup->type = $type;
            }
            $lookup->attributes = $_POST['Lookup'];
            if ($lookup->save()) {
                user()->addFlash(t('Lookup has been saved.'), 'success');
                $this->redirect(array('lookup/view', 'type' => $type));
            }
            else {
                user()->addFlash(t('Lookup could not be saved.'), 'error');
            }
        }

        // render view
        $this->render('view', array(
            'types' => $types,
            'type' => $type,
            'lookups' => $lookups,
            'lookup' => $lookup,
        ));
    }

}

<?php
/**
 * NoteController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class NoteController extends WebController
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
        $note = new Note('search');
        if (!empty($_GET['Note']))
            $note->attributes = $_GET['Note'];

        $this->render('index', array(
            'note' => $note,
        ));
    }

    /**
     * View
     * @param $id
     */
    public function actionView($id)
    {
        /** @var $note Note */
        $note = $this->loadModel($id);

        // check for deleted Note
        if ($note->deleted) {
            user()->addFlash('THIS RECORD IS DELETED', 'warning');
        }

        $this->render('view', array(
            'note' => $note,
        ));
    }

    /**
     * Log
     * @param $id
     */
    public function actionLog($id)
    {
        /** @var $note Note */
        $note = $this->loadModel($id);

        $this->render('log', array(
            'note' => $note,
        ));
    }

    /**
     * Create
     */
    public function actionCreate()
    {
        $note = new Note('create');

        $this->performAjaxValidation($note, 'note-form');
        if (isset($_POST['Note'])) {
            $note->attributes = $_POST['Note'];
            if ($note->save()) {
                user()->addFlash(strtr('Note :name has been created.', array(':name' => $note->getName())), 'success');
                $this->redirect(ReturnUrl::getUrl($note->getUrl()));
            }
            user()->addFlash(t('Note could not be created.'), 'warning');
        }
        else {
            if (isset($_GET['Note'])) {
                $note->attributes = $_GET['Note'];
            }
        }

        $this->render('create', array(
            'note' => $note,
        ));
    }

    /**
     * Update
     * @param $id
     */
    public function actionUpdate($id)
    {
        /** @var $note Note */
        $note = $this->loadModel($id);

        $this->performAjaxValidation($note, 'note-form');
        if (isset($_POST['Note'])) {
            $note->attributes = $_POST['Note'];
            if ($note->save()) {
                user()->addFlash(strtr('Note :name has been updated.', array(':name' => $note->getName())), 'success');
                $this->redirect(ReturnUrl::getUrl($note->getUrl()));
            }
            user()->addFlash(t('Note could not be updated.'), 'warning');
        }

        $this->render('update', array(
            'note' => $note,
        ));
    }

    /**
     * Delete and Undelete
     * @param $id
     */
    public function actionDelete($id = null)
    {
        $task = sf('task', 'Note') == 'undelete' ? 'undelete' : 'delete';
        if (sf('confirm', 'Note')) {
            $ids = sfGrid($id);
            foreach ($ids as $id) {
                $note = Note::model()->findByPk($id);
                if (!$note) {
                    continue;
                }
                call_user_func(array($note, $task));
                user()->addFlash(strtr('Note :name has been :tasked.', array(
                    ':name' => $note->getName(),
                    ':tasked' => $task . 'd',
                )), 'success');
            }
            $this->redirect(ReturnUrl::getUrl(user()->getState('index.note', array('/note/index'))));
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

}

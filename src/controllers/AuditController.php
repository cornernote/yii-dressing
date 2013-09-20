<?php

/**
 * AuditController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class AuditController extends WebController
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
                'actions' => array('index', 'view', 'preserve', 'unPreserve'),
                'roles' => array('admin'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * Lists all Audits.
     */
    public function actionIndex()
    {
        $audit = new Audit('search');
        if (!empty($_GET['Audit']))
            $audit->attributes = $_GET['Audit'];
        $urlManager = app()->getUrlManager();
        $urlManager->setUrlFormat('get');
        $this->render('index', array(
            'audit' => $audit,
        ));
    }


    /**
     * Displays a particular Audit.
     * @param integer $id the ID of the Audit to be displayed
     */
    public function actionView($id)
    {
        $audit = $this->loadModel($id);
        $this->render('view', array(
            'audit' => $audit,
        ));
    }

    /**
     * Preserves a particular Audit.
     * @param integer $id the ID of the Audit to be displayed
     * @param int $status
     * @return void
     */
    public function actionPreserve($id, $status = 1)
    {
        $id = (int)$id;
        $status = (int)$status;
        $audit = $this->loadModel($id);
        //$sql = "UPDATE " . Audit::model()->tableName() . " SET preserve = $status WHERE id = $id";
        //app()->db->createCommand($sql)->execute();
        $audit->preserve = $status;
        $audit->save(false);
        $this->redirect($audit->getUrl(), true);
    }

}

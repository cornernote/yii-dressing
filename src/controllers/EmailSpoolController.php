<?php

/**
 * EmailSpoolController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class EmailSpoolController extends WebController
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
                'actions' => array('index', 'view'),
                'roles' => array('admin'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * Lists all emailSpools.
     */
    public function actionIndex()
    {
        $emailSpool = new EmailSpool('search');
        $this->render('index', array(
            'emailSpool' => $emailSpool,
        ));
    }

    /**
     * Displays a particular EmailSpool.
     * @param integer $id the ID of the EmailSpool to be displayed
     */
    public function actionView($id)
    {
        $emailSpool = $this->loadModel($id);
        $this->render('view', array(
            'emailSpool' => $emailSpool,
        ));
    }

}

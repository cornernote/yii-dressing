<?php

/**
 * AuditTrailController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class AuditTrailController extends WebController
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
                'actions' => array('index'),
                'roles' => array('admin'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * Lists all AuditTrails.
     */
    public function actionIndex()
    {
        $auditTrail = new AuditTrail('search');
        $this->render('index', array(
            'auditTrail' => $auditTrail,
        ));
    }

}

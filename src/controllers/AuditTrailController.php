<?php

/**
 * AuditTrailController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class AuditTrailController extends YdWebController
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
        $auditTrail = new YdAuditTrail('search');
        $this->render('dressing.views.auditTrail.index', array(
            'auditTrail' => $auditTrail,
        ));
    }

}

<?php

/**
 * YdEmailSpoolController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.controllers
 */
class YdEmailSpoolController extends YdWebController
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
                'actions' => array('index', 'view', 'log'),
                'roles' => array('admin'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * @param string $view the view to be rendered
     * @return bool
     */
    public function beforeRender($view)
    {
        $this->addBreadcrumb(Yii::t('dressing', 'Tools'), array('/tool/index'));
        if (in_array($view, array('view', 'log'))) {
            $this->addBreadcrumb(Yii::t('dressing', 'Email Spools'), Yii::app()->user->getState('index.emailSpool', array('/emailSpool/index')));
        }
        return parent::beforeRender($view);
    }

    /**
     * Lists all emailSpools.
     */
    public function actionIndex()
    {
        $emailSpool = new YdEmailSpool('search');
        $this->render('index', array(
            'emailSpool' => $emailSpool,
        ));
    }

    /**
     * Displays a particular YdEmailSpool.
     * @param integer $id the ID of the YdEmailSpool to be displayed
     */
    public function actionView($id)
    {
        $emailSpool = $this->loadModel($id, 'YdEmailSpool');
        $this->render('view', array(
            'emailSpool' => $emailSpool,
        ));
    }

    /**
     * Displays logs for a particular YdEmailSpool.
     * @param integer $id the ID of the YdEmailSpool to be displayed
     */
    public function actionLog($id)
    {
        $emailSpool = $this->loadModel($id, 'YdEmailSpool');
        $this->render('log', array(
            'emailSpool' => $emailSpool,
        ));
    }

}

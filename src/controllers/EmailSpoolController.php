<?php

/**
 * EmailSpoolController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.controllers
 */
class EmailSpoolController extends YdWebController
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
        $emailSpool = new YdEmailSpool('search');
        $this->render('dressing.views.emailSpool.index', array(
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
        $this->render('dressing.views.emailSpool.view', array(
            'emailSpool' => $emailSpool,
        ));
    }

}

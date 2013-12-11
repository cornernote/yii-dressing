<?php

/**
 * YdEmailTemplateController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.controllers
 */
class YdEmailTemplateController extends YdWebController
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
                'actions' => array('index', 'view', 'update'),
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
        if (in_array($view, array('view', 'update'))) {
            $this->addBreadcrumb(Yii::t('dressing', 'Email Templates'), Yii::app()->user->getState('index.emailTemplate', array('/emailTemplate/index')));
        }
        return parent::beforeRender($view);
    }

    /**
     * Lists all print methods.
     */
    public function actionIndex()
    {
        $emailTemplate = new YdEmailTemplate('search');
        $this->render('index', array(
            'emailTemplate' => $emailTemplate,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $emailTemplate = $this->loadModel($id, 'YdEmailTemplate');

        // render the page
        $this->render('view', array(
            'emailTemplate' => $emailTemplate,
        ));
    }

    /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $emailTemplate = $this->loadModel($id, 'YdEmailTemplate');

        // handle posted data
        if (isset($_POST['YdEmailTemplate'])) {
            $emailTemplate->attributes = $_POST['YdEmailTemplate'];
            if ($emailTemplate->save()) {
                Yii::app()->user->addFlash(Yii::t('dressing', 'Email Template has been updated'), 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl($emailTemplate->getUrl()));
            }
        }
        else {
            // pre-fill the form with variables from _GET
            if (isset($_GET['YdEmailTemplate'])) {
                $emailTemplate->attributes = $_GET['YdEmailTemplate'];
            }
        }

        // render the page
        $this->render('update', array(
            'emailTemplate' => $emailTemplate,
        ));
    }

}

<?php

/**
 * EmailTemplateController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class EmailTemplateController extends YdWebController
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
     * Lists all print methods.
     */
    public function actionIndex()
    {
        $emailTemplate = new YdEmailTemplate('search');
        $this->render('dressing.views.emailTemplate.index', array(
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
        $this->render('dressing.views.emailTemplate.view', array(
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
        $this->performAjaxValidation($emailTemplate, 'emailTemplate-form');

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
        $this->render('dressing.views.emailTemplate.update', array(
            'emailTemplate' => $emailTemplate,
        ));
    }

}

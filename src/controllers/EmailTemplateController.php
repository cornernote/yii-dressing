<?php

/**
 * EmailTemplateController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class EmailTemplateController extends WebController
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
        $emailTemplate = new EmailTemplate('search');
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
        $emailTemplate = $this->loadModel($id);

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
        $emailTemplate = $this->loadModel($id);
        $this->performAjaxValidation($emailTemplate, 'emailTemplate-form');

        // handle posted data
        if (isset($_POST['EmailTemplate'])) {
            $emailTemplate->attributes = $_POST['EmailTemplate'];
            if ($emailTemplate->save()) {
                $this->flashAndRedirect(t('Email Template has been updated'), 'success');
            }
            else {
                user()->addFlash('Email Template could not be updated', 'warning');
            }

        }
        else {
            // pre-fill the form with variables from _GET
            if (isset($_GET['EmailTemplate'])) {
                $emailTemplate->attributes = $_GET['EmailTemplate'];
            }
        }

        // render the page
        $this->render('update', array(
            'emailTemplate' => $emailTemplate,
        ));
    }

}

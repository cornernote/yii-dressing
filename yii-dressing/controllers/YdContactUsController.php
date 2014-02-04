<?php

/**
 * YdContactUsController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.controllers
 */
class YdContactUsController extends YdWebController
{

    /**
     * Access Control
     * @return array
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'view', 'log', 'create', 'delete'),
                'roles' => array('admin'),
                //'users' => array('*','@','?'), // all, user, guest
            ),
            array('allow',
                'actions' => array('contact', 'thankYou'),
                'users' => array('*'),
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
            $this->addBreadcrumb(Yii::t('dressing', 'Contact Us'), Yii::app()->user->getState('index.contactUs', array('/contactUs/index')));
        }
        if ($view == 'thankYou') {
            $this->addBreadcrumb(Yii::t('dressing', 'Contact Us'), array('/contactUs/contact'));
        }
        return parent::beforeRender($view);
    }

    /**
     * Index
     */
    public function actionIndex()
    {
        $contactUs = new YdContactUs('search');
        if (!empty($_GET['YdContactUs']))
            $contactUs->attributes = $_GET['YdContactUs'];

        $this->render('index', array(
            'contactUs' => $contactUs,
        ));
    }

    /**
     * View
     * @param $id
     */
    public function actionView($id)
    {
        /** @var $contactUs YdContactUs */
        $contactUs = $this->loadModel($id, 'YdContactUs');

        $this->render('view', array(
            'contactUs' => $contactUs,
        ));
    }

    /**
     * Log
     * @param $id
     */
    public function actionLog($id)
    {
        /** @var $contactUs YdContactUs */
        $contactUs = $this->loadModel($id, 'YdContactUs');

        $this->render('log', array(
            'contactUs' => $contactUs,
        ));
    }

    /**
     * Create
     */
    public function actionContact()
    {
        $contactUs = new YdContactUs('create');

        if (isset($_POST['YdContactUs'])) {
            $contactUs->attributes = $_POST['YdContactUs'];
            $contactUs->ip_address = si($_SERVER, 'REMOTE_ADDR');
            $contactUs->message = format()->formatNtext($contactUs->message);
            if ($contactUs->save()) {
                EMailHelper::sendContactEmail($contactUs);
                Yii::app()->user->addFlash(Yii::t('dressing', 'Your message has been sent successfully.'), 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl(array('contactUs/thankYou')));
            }
            Yii::app()->user->addFlash(Yii::t('dressing', 'Could not send the message.'), 'error');
        }
        else {
            if (isset($_GET['YdContactUs'])) {
                $contactUs->attributes = $_GET['YdContactUs'];
            }
        }

        $this->render('contact', array(
            'contactUs' => $contactUs,
        ));
    }

    /**
     * @param $id
     */
    public function actionThankYou($id)
    {
        /** @var $contactUs YdContactUs */
        $contactUs = $this->loadModel($id, 'YdContactUs');

        $this->render('thank_you', array(
            'contactUs' => $contactUs,
        ));
    }

}

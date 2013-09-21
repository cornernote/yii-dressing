<?php
/**
 *
 */
class ContactUsController extends YdWebController
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
     * Index
     */
    public function actionIndex()
    {
        $contactUs = new YdContactUs('search');
        if (!empty($_GET['YdContactUs']))
            $contactUs->attributes = $_GET['YdContactUs'];

        $this->render('dressing.views.contactUs.index', array(
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

        $this->render('dressing.views.contactUs.view', array(
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

        $this->render('dressing.views.contactUs.log', array(
            'contactUs' => $contactUs,
        ));
    }

    /**
     * Create
     */
    public function actionContact()
    {
        $contactUs = new YdContactUs('create');

        $this->performAjaxValidation($contactUs, 'contactUs-form');
        if (isset($_POST['YdContactUs'])) {
            $contactUs->attributes = $_POST['YdContactUs'];
            $contactUs->ip_address = si($_SERVER, 'REMOTE_ADDR');
            $contactUs->message = format()->formatNtext($contactUs->message);
            if ($contactUs->save()) {
                EMailHelper::sendContactEmail($contactUs);
                Yii::app()->user->addFlash(Yii::t('dressing', 'Your message has been sent successfully.'), 'success');
                $this->redirect(Yii::app()->returnUrl->getUrl(array('contactUs/thankYou')));
            }
            Yii::app()->user->addFlash(Yii::t('dressing', 'Could not communicate the message.'), 'warning');
        }
        else {
            if (isset($_GET['YdContactUs'])) {
                $contactUs->attributes = $_GET['YdContactUs'];
            }
        }

        $this->render('dressing.views.contactUs.contact', array(
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

        $this->render('dressing.views.contactUs.thank_you', array(
            'contactUs' => $contactUs,
        ));
    }

}

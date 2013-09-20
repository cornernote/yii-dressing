<?php
/**
 *
 */
class ContactUsController extends WebController
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
        $contactUs = new ContactUs('search');
        if (!empty($_GET['ContactUs']))
            $contactUs->attributes = $_GET['ContactUs'];

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
        /** @var $contactUs ContactUs */
        $contactUs = $this->loadModel($id);

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
        /** @var $contactUs ContactUs */
        $contactUs = $this->loadModel($id);

        $this->render('log', array(
            'contactUs' => $contactUs,
        ));
    }

    /**
     * Create
     */
    public function actionContact()
    {
        $contactUs = new ContactUs('create');

        $this->performAjaxValidation($contactUs, 'contactUs-form');
        if (isset($_POST['ContactUs'])) {
            $contactUs->attributes = $_POST['ContactUs'];
            $contactUs->created_at = date('Y-m-d H:i:s');
            $contactUs->ip_address = si($_SERVER, 'REMOTE_ADDR');
            $contactUs->message = format()->formatNtext($contactUs->message);
            if ($contactUs->save()) {
                EMailHelper::sendContactEmail($contactUs);
                user()->addFlash(t('Your message has been sent successfully.'), 'success');
                $this->redirect(ReturnUrl::getUrl(array('contactUs/thankYou')));
            }
            user()->addFlash(t('Could not communicate the message.'), 'warning');
        }
        else {
            if (isset($_GET['ContactUs'])) {
                $contactUs->attributes = $_GET['ContactUs'];
            }
        }

        $this->render('contact', array(
            'contactUs' => $contactUs,
        ));
    }
    public function actionThankYou()
    {
        $this->render('thank_you', array(
            //'contactUs' => $contactUs,
        ));
    }

}

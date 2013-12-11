<?php
/**
 * YdWebControllerBehavior
 *
 * @property CController $owner
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.behaviors
 */
class YdWebControllerBehavior extends CBehavior
{

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array breadcrumbs links to current page. This property will be assigned to {@link CBreadcrumbs::links}.
     */
    protected $_breadcrumbs = array();

    /**
     * @var
     */
    protected $_pageHeading;

    /**
     * @var
     */
    public $pageSubheading;

    /**
     * @var
     */
    public $pageIcon;

    /**
     * @var
     */
    public $showNavBar = true;

    /**
     * @var bool
     */
    protected $_isModal;

    /**
     * @var
     */
    protected $_loadModel;

    /**
     * Gets the humanized name of the controller
     *
     * @param bool $plural
     * @return string
     */
    public function getName($plural = false)
    {
        $name = preg_replace('/(?<![A-Z])[A-Z]/', ' \0', str_replace('Controller', '', get_class($this->getOwner())));
        $name = ucwords(trim(strtolower(str_replace(array('-', '_', '.'), ' ', $name))));
        return $name . ($plural ? 's' : '');
    }

    /**
     * @return string Defaults to the controllers pageTitle.
     */
    public function getPageHeading()
    {
        if ($this->_pageHeading === null)
            $this->_pageHeading = $this->getOwner()->pageTitle;
        return $this->_pageHeading;
    }

    /**
     * @param $pageHeading string
     */
    public function setPageHeading($pageHeading)
    {
        $this->_pageHeading = $pageHeading;
    }

    /**
     * @return string
     */
    public function getBreadcrumbs()
    {
        if ($this->_breadcrumbs === null)
            $this->_breadcrumbs = $this->pageTitle;
        return $this->_breadcrumbs;
    }

    /**
     * @param string $breadcrumbs
     */
    public function setBreadcrumbs($breadcrumbs)
    {
        $this->_breadcrumbs = $breadcrumbs;
    }

    /**
     * @param string $name
     * @param array|string $link
     */
    public function addBreadcrumb($name, $link = null)
    {
        if ($link)
            $this->_breadcrumbs[$name] = $link;
        else
            $this->_breadcrumbs[] = $name;
    }

    /**
     * @return bool
     */
    public function getIsModal()
    {
        if ($this->_isModal === null)
            $this->_isModal = Yii::app()->getRequest()->isAjaxRequest;
        return $this->_isModal;
    }

    /**
     * @param bool $isModal
     */
    public function setIsModal($isModal)
    {
        $this->_isModal = $isModal;
    }

    /**
     * Performs the AJAX validation for one or more CActiveRecord models
     *
     * @param CActiveRecord|CActiveRecord[] $model
     * @param $form
     */
    protected function performAjaxValidation($model, $form)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $form) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Performs validation for one or more CActiveRecord models
     *
     * @param CActiveRecord|CActiveRecord[] $model
     * @return bool
     */
    protected function performValidation($model)
    {
        if (!is_array($model))
            $model = array($model);
        $valid = true;
        foreach ($model as $_model)
            if (!$_model->validate())
                $valid = false;
        return $valid;
    }

    /**
     * Loads a CActiveRecord or throw a CHTTPException
     *
     * @param $id
     * @param bool|string $model
     * @return CActiveRecord
     * @throws CHttpException
     */
    public function loadModel($id, $model = false)
    {
        if (!$model)
            $model = str_replace('Controller', '', get_class($this->owner));
        if ($this->_loadModel === null) {
            $this->_loadModel = CActiveRecord::model($model)->findbyPk($id);
            if ($this->_loadModel === null)
                throw new CHttpException(404, Yii::t('dressing', 'The requested page does not exist.'));
        }
        return $this->_loadModel;
    }

    /**
     * Gives the user a flash message and then redirects them
     *
     * @param string $message
     * @param string $messageType
     * @param mixed $url
     */
    protected function flashRedirect($message, $messageType = 'info', $url = null)
    {
        Yii::app()->user->addFlash($message, $messageType);
        if (!Yii::app()->request->isAjaxRequest)
            $this->owner->redirect($url ? $url : Yii::app()->returnUrl->getUrl());
        Yii::app()->end();
    }

}
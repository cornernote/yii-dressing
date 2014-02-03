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
        Yii::import('dressing.components.YdCakeInflector');
        $name = YdCakeInflector::humanize(YdCakeInflector::underscore(str_replace('Controller', '', get_class($this->getOwner()))));
        return $plural ? YdCakeInflector::pluralize($name) : $name;
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
     *
     */
    public function getPageBreadcrumbs()
    {
        $breadcrumbs = $this->_breadcrumbs;
        $breadcrumbs[] = $this->owner->pageTitle;
        return $breadcrumbs;
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
    public function performAjaxValidation($model, $form)
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
    public function performValidation($model)
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
            $this->_loadModel = CActiveRecord::model($model)->findByPk($id);
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
    public function flashRedirect($message, $messageType = 'info', $url = null)
    {
        Yii::app()->user->addFlash($message, $messageType);
        if (!Yii::app()->request->isAjaxRequest)
            $this->owner->redirect($url ? $url : Yii::app()->returnUrl->getUrl());
        Yii::app()->end();
    }

    /**
     * Gets a submitted field
     * used to be named getSubmittedField()
     *
     * @param $field
     * @param null $model
     * @return mixed
     */
    public function getSubmittedField($field, $model = null)
    {
        $return = null;
        if ($model && isset($_GET[$model][$field])) {
            $return = $_GET[$model][$field];
        }
        elseif ($model && isset($_POST[$model][$field])) {
            $return = $_POST[$model][$field];
        }
        elseif (isset($_GET[$field])) {
            $return = $_GET[$field];
        }
        elseif (isset($_POST[$field])) {
            $return = $_POST[$field];
        }
        return $return;
    }

    /**
     * @param $ids
     * @return array
     */
    public function getGridIds($ids = null)
    {
        if (!$ids)
            $ids = array();
        if (!is_array($ids))
            $ids = explode(',', $ids);
        foreach ($_REQUEST as $k => $v) {
            if (strpos($k, '-grid_c0') === false || !is_array($v))
                continue;
            foreach ($v as $vv) {
                $ids[$vv] = $vv;
            }
        }
        return $ids;
    }

}
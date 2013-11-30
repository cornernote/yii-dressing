<?php
/**
 * Class YdWebController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.components
 */
class YdWebController extends YdController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = 'dressing.views.layouts.default';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    /**
     * @var
     */
    public $pageHeading;

    /**
     * @var
     */
    public $pageSubheading;

    /**
     * @var
     */
    public $ajaxHeading;

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
    public $isModal = false;

    /**
     * @var
     */
    protected $loadModel;

    /**
     * @param bool $plural
     * @return mixed
     */
    public function getName($plural = false)
    {
        return ucwords(trim(strtolower(str_replace(array('-', '_', '.'), ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', str_replace('Controller', '', get_class($this))))))) . ($plural ? 's' : '');
    }

    /**
     * Initializes the controller.
     * This method is called by the application before the controller starts to execute.
     */
    public function init()
    {
        parent::init();

        // if returnUrl is in submitted data it will be saved in session
        Yii::app()->returnUrl->setUrlFromSubmitFields();

        // set user theme
        if ($theme = Yii::app()->user->getState('theme'))
            Yii::app()->setTheme($theme);

        // decide if this is a modal
        $this->isModal = Yii::app()->getRequest()->isAjaxRequest;
    }

    /**
     * Performs the AJAX validation.
     * @param $model CActiveRecord|CActiveRecord[]
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
     * @param $model CActiveRecord|CActiveRecord[]
     * @return bool
     */
    protected function performValidation($model)
    {
        if (!is_array($model)) {
            $model = array($model);
        }
        $valid = true;
        /** @var CActiveRecord[] $model */
        foreach ($model as $_model) {
            if (!$_model->validate()) {
                $valid = false;
            }
        }
        return $valid;
    }

    /**
     * @param $id
     * @param bool|string $model
     * @return CActiveRecord
     * @throws CHttpException
     */
    public function loadModel($id, $model = false)
    {
        if (!$model)
            $model = str_replace('Controller', '', get_class($this));
        if ($this->loadModel === null) {
            $this->loadModel = CActiveRecord::model($model)->findbyPk($id);
            if ($this->loadModel === null)
                throw new CHttpException(404, Yii::t('dressing', 'The requested page does not exist.'));
        }
        return $this->loadModel;
    }

    /**
     * @param $message
     * @param $messageType
     * @param null $url
     */
    protected function flashRedirect($message, $messageType = 'info', $url = null)
    {
        Yii::app()->user->addFlash($message, $messageType);
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect($url ? $url : Yii::app()->returnUrl->getUrl());
        }
        Yii::app()->end();
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

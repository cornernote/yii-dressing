<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class YdWebController extends YdController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/default';

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
    public $pageIcon;

    /**
     * @var
     */
    public $showNavBar = true;

    /**
     * @return mixed
     */
    public function getName()
    {
        return ucwords(trim(strtolower(str_replace(array('-', '_', '.'), ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', str_replace('Controller', '', get_class($this)))))));
    }

    /**
     * Initializes the controller.
     * This method is called by the application before the controller starts to execute.
     */
    public function init()
    {
        parent::init();

        // ensure the user is an api login
        if (!Yii::app()->user->isGuest && Yii::app()->user->getState('UserIdentity.api')) {
            Yii::app()->user->addFlash(Yii::t('dressing', 'Please login to the web interface.'));
            Yii::app()->user->logout();
            $this->redirect(Yii::app()->homeUrl);
        }

        // set user theme
        $theme = Yii::app()->user->setting('theme');
        if ($theme) {
            app()->theme = $theme;
        }
    }

    /**
     * This method is invoked right before an action is to be executed (after all possible filters.)
     * @param CAction $action the action to be executed.
     * @return boolean whether the action should be executed.
     */
    protected function beforeAction($action)
    {
        // if returnUrl is in submitted data it will be saved in session
        Yii::app()->returnUrl->setUrlFromSubmitFields();
        return parent::beforeAction($action);
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
     * @param $id
     * @return array
     */
    public function getGridIds($id)
    {
        $ids = array();
        $gridData = array();
        if (!empty($_REQUEST)) {
            foreach ($_REQUEST as $k => $v) {
                if (strpos($k, '-grid_c0') !== false) {
                    if (is_array($v)) {
                        $gridData = $v;
                    }

                }
            }
        }
        if (!empty($gridData)) {
            foreach ($gridData as $id) {
                $ids[$id] = $id;
            }
        }
        else {
            if ($id) {
                $ids[$id] = $id;
            }
        }
        return $ids;
    }

    /**
     * @param null $id
     * @return string
     */
    public function getGridIdHiddenFields($id = null)
    {
        $inputs = array();
        foreach ($this->getGridIds($id) as $id) {
            $inputs[] = CHtml::hiddenField('hidden-sf-grid_c0[]', $id);
        }
        return implode("\n", $inputs);
    }

}

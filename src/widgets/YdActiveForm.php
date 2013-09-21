<?php
Yii::import('bootstrap.widgets.TbActiveForm');

/**
 * Class ActiveForm
 */
class YdActiveForm extends TbActiveForm
{
    /**
     * @var ActiveFormModel
     */
    public $model;

    /**
     * @var
     */
    public $askToSaveWork;

    /**
     * Initializes the widget.
     * This renders the form open tag.
     */
    public function init()
    {
        // modal-form for popups
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($this->htmlOptions['class'])) {
                $this->htmlOptions['class'] = '';
            }
            $this->htmlOptions['class'] .= ' modal-form';
        }

        // get a model we can use for this form
        $this->model = new ActiveFormModel();

        // init the parent (output <form> tag)
        parent::init();

        // output the return url
        echo CHtml::hiddenField('returnUrl', Yii::app()->returnUrl->getFormValue());

        // ask to save work
        if ($this->askToSaveWork)
            Yii::app()->controller->widget('widgets.AskToSaveWork', array('watchElement' => '#setting-form :input', 'message' => t('Please save before leaving the page')));

    }

    /**
     * @return string
     */
    public function beginModalWrap()
    {
        // more modal stuff
        if (Yii::app()->getRequest()->isAjaxRequest) {
            return '<div class="modal-body">';
        }
        return '';
    }

    /**
     * @return string
     */
    public function endModalWrap()
    {
        // more modal stuff
        if (Yii::app()->getRequest()->isAjaxRequest) {
            return '</div>';
        }
        return '';
    }

    /**
     * @return string
     */
    public function getSubmitRowClass()
    {
        return Yii::app()->getRequest()->isAjaxRequest ? 'modal-footer' : 'form-actions';
    }

}
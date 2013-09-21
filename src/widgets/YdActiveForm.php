<?php
Yii::import('bootstrap.widgets.TbActiveForm');

/**
 * Class YdActiveForm
 */
class YdActiveForm extends TbActiveForm
{

    /**
     * @var YdActiveFormModel
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
        $this->model = new YdActiveFormModel();

        // init the parent (output <form> tag)
        parent::init();

        // output the return url
        echo CHtml::hiddenField('returnUrl', Yii::app()->returnUrl->getFormValue());

        // ask to save work
        if ($this->askToSaveWork)
            Yii::app()->controller->widget('widgets.AskToSaveWork', array('watchElement' => '#setting-form :input', 'message' => Yii::t('dressing', 'Please save before leaving the page.')));

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

    /**
     * @param $buttonId
     * @param $hiderId
     */
    public function searchToggle($buttonClass, $gridId = null)
    {
        $script = "$('." . $buttonClass . "').click(function(){ $('#" . $this->id . "').toggle(); });";
        if ($gridId) {
            $script .= "
                $('#" . $this->id . "').submit(function(){
                    $.fn.yiiGridView.update('" . $gridId . "', {url: $(this).attr('action'),data: $(this).serialize()});
                    return false;
                });
            ";
        }
        Yii::app()->clientScript->registerScript($this->id . '-searchToggle', $script, CClientScript::POS_READY);
    }

}
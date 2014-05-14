<?php
Yii::import('bootstrap.widgets.TbActiveForm');

/**
 * Class YdActiveForm
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.widgets
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
    public $returnUrl;

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
        Yii::import('dressing.components.YdActiveFormModel');
        $this->model = $this->model ? $this->model : new YdActiveFormModel();

        // init the parent (output <form> tag)
        parent::init();

        // output the return url
        if ($this->returnUrl !== false)
            echo CHtml::hiddenField('returnUrl', $this->returnUrl ? $this->returnUrl : Yii::app()->returnUrl->getFormValue());

        // ask to save work
        if ($this->askToSaveWork)
            Yii::app()->controller->widget('dressing.widgets.YdAskToSaveWork', array('watchElement' => '#setting-form :input', 'message' => Yii::t('dressing', 'Please save before leaving the page.')));

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


    /**
     * @param null $id
     * @return string
     */
    public function getGridIdHiddenFields($ids)
    {
        $inputs = array();
        foreach ($ids as $id) {
            $inputs[] = CHtml::hiddenField('hidden-sf-grid_c0[]', $id);
        }
        return implode("\n", $inputs);
    }

    /**
     * @param null $label
     * @param array $options
     * @return string
     */
    public function getSubmitButtonRow($label = null, $buttonHtmlOptions = array(), $rowHtmlOptions = array())
    {
        if (!isset($buttonHtmlOptions['color']))
            $buttonHtmlOptions['color'] = TbHtml::BUTTON_COLOR_PRIMARY;
        $rowHtmlOptions['class'] = isset($rowOptions['class']) ? $rowOptions['class'] . ' ' . $this->getSubmitRowClass() : $this->getSubmitRowClass();
        return CHtml::tag('div', $rowHtmlOptions, TbHtml::submitButton($label, $buttonHtmlOptions));
    }

}
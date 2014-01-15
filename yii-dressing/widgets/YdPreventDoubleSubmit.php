<?php

/**
 *
 */
class YdPreventDoubleSubmit extends CWidget
{

    /**
     *
     */
    public function init()
    {
        Yii::app()->clientScript->registerScript($this->id, "$(document).on('submit', 'form:not(.allow-double-submit)', function (e) {
            var form = $(this); if (form.data('submitted') !== true) { form.data('submitted', true); } else {  e.preventDefault(); }
        });", CClientScript::POS_END);
        parent::init();
    }

}
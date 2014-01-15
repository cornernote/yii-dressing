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
        $script = "// prevent double submit
        $(document).on('submit', 'form:not(.js-allow-double-submit)', function (e) {
            var form = $(this);
            // Previously submitted - don't submit again
            if (form.data('submitted') === true) { e.preventDefault(); }
            // Mark it so that the next submit can be ignored
            else { form.data('submitted', true); }
        });";
        Yii::app()->clientScript->registerScript($this->id, $script, CClientScript::POS_READY);
        parent::init();
    }

}
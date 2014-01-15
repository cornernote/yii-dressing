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
        $baseUrl = Yii::app()->dressing->getAssetsUrl();
        $clientScript = Yii::app()->clientScript;
        $clientScript->registerScriptFile($baseUrl . '/js/prevent-double-submit.js');
        $script = "// prevent double submit
        $(document).on('submit', 'form:not(.js-allow-double-submit)', function (e) {
            var form = $(this);
            // Previously submitted - don't submit again
            if (form.data('submitted') === true) { e.preventDefault(); }
            // Mark it so that the next submit can be ignored
            else { form.data('submitted', true); }
        });";
        $clientScript->registerScript($this->id, $script, CClientScript::POS_READY);
        parent::init();
    }

}
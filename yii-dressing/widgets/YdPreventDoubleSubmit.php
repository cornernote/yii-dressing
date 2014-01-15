<?php

/**
 * YdPreventDoubleSubmit
 *
 * Prevents double form submissions on all forms.
 * If you need to double-submit on some forms give them class="allow-double-submit".
 * Uses $(document).on('submit', ... ) so that dynamically loaded forms are selected.
 *
 * @see http://stackoverflow.com/questions/2830542/prevent-double-submission-of-forms-in-jquery
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.widgets
 */
class YdPreventDoubleSubmit extends CWidget
{

    /**
     * @var string The jQuery selector, by default all forms except those with class="allow-double-submit"
     */
    public $selector = 'form:not(.allow-double-submit)';

    /**
     * Register jQuery and the JavaScript to prevent Double Form Submission
     */
    public function init()
    {
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        $cs->registerScript($this->id, "$(document).on('submit', '" . $this->selector . "', function (e) {
            var form = $(this); if (form.data('submitted') !== true) { form.data('submitted', true); form.find(':submit').attr('disabled', true); } else { e.preventDefault(); }
        });", CClientScript::POS_END);
        parent::init();
    }

}

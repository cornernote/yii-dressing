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
    public $formSelector = 'form:not(.allow-double-submit)';

    /**
     * @var string The jQuery selector, by default only links with class="prevent-double-click"
     */
    public $linkSelector = 'a.prevent-double-click';

    /**
     * Register jQuery and the JavaScript to prevent Double Form Submission
     */
    public function init()
    {
        parent::init();
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');

        // forms
        $cs->registerScript($this->id . '-form', "$(document).on('submit', '" . $this->formSelector . "', function (e) {
            var form = $(this); 
            if (form.data('submitted') !== true) { 
                form.data('submitted', true); 
                form.find(':submit').attr('disabled', true); 
            } 
            else {
                e.preventDefault(); 
            }
        });", CClientScript::POS_END);

        // links
        $cs->registerScript($this->id . '-form', "$(document).on('click', '" . $this->linkSelector . "', function (e) {
            var link = $(this);
            if (link.data('clicked') !== true) {
                link.data('clicked', true);
                link.attr('disabled', true);
            }
            else {
                e.preventDefault();
            }
        });", CClientScript::POS_END);
    }

}

<?php

/**
 * This extension ask for a confirmation to user before leaving the page
 * when he is editing or creating something
 *
 *
 * USAGE:
 * $this->widget('widgets.AskToSaveWork', array('watchElement' => '#my-form :input', 'message' => Yii::t('dressing', 'Please save before leaving the page')));
 *
 *
 * @author aleksdj
 */
class YdAskToSaveWork extends CWidget
{

    /**
     * @var String Message to show to user preventing exit the page
     */
    public $message;

    /**
     * @var String input element (ex. #Page_title, .Page_description) to watch,
     * allowing to us know if user is already editing or not (avoiding unnecesary messages)
     */
    public $watchElement;

    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->message = isset($this->message) ? $this->message : Yii::t('messages', "Please save before leaving the page");
    }

    /**
     *
     */
    public function run()
    {
        parent::run();
        $js = '';

        if (isset($this->watchElement)) {
            $js .= "$('$this->watchElement').one('change', function() {";
        }

        $js .= "$(window).bind('beforeunload', function() {
                return \"" . $this->message . "\" ;
            });";

        $js .= "$(':submit').bind('click', function(){
                window.onbeforeunload = function(){};
                $(window).unbind('beforeunload');
            });";

        if (isset($this->watchElement)) {
            $js .= "});";
        }

        app()->clientScript->registerCoreScript('jquery');
        app()->clientScript->registerScript($this->getId(), $js, CClientScript::POS_READY);
    }
}


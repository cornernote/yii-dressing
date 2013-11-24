<?php

/**
 * YdAskToSaveWork will ask for a confirmation to user before leaving the page after they make a change to the form.
 *
 * USAGE:
 * <pre>
 * $this->widget('widgets.AskToSaveWork', array(
 *     'watchElement' => '#my-form :input',
 *     'message' => Yii::t('app', 'Please save before leaving the page')
 * ));
 * </pre>
 *
 * @author aleksdj
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.widgets
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


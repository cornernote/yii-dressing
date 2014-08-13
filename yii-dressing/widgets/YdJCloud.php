<?php
/**
 * YdJCloud class file.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Stefan Volkmar <volkmar_yii@email.de>
 * @copyright 2014 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.widgets
 */

/**
 * This widget encapsulates the jQCloud plugin for jQuery for drawing neat word clouds that actually look like clouds.
 * ({@link https://github.com/DukeLeNoir/jQCloud}).
 *
 * @author Stefan Volkmar <volkmar_yii@email.de>
 */
class YdJCloud extends CWidget
{
    /**
     * @var array the wordlist
     */
    public $wordList;

    /**
     * @var string the name of the container element that contains the word cloud.
     * Defaults to 'div'.
     */
    public $tagName = 'div';

    /**
     * @var array the HTML attributes that should be rendered in the HTML tag
     * which contain the word cloud.
     */
    public $htmlOptions = array();

    /**
     * @var mixed the CSS file used for the widget.
     * If false, the default CSS file will be used. Otherwise, the specified CSS file
     * will be included when using this widget.
     */
    public $cssFile = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        $id = $this->getId();
        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;

        if (!isset($this->htmlOptions['class']))
            $this->htmlOptions['class'] = 'jqcloud';

        $baseUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets.jqcloud'), false, 1, YII_DEBUG);

        $url = ($this->cssFile !== false)
            ? $this->cssFile
            : $baseUrl . '/css/jqcloud.css';

        $cloudJs = (YII_DEBUG)
            ? "/js/jqcloud-0.2.4.js"
            : "/js/jqcloud-0.2.4.min.js";

        $wordList = ($this->wordList === array())
            ? '[]'
            : CJavaScript::encode($this->wordList);

        Yii::app()->getClientScript()
            ->registerCoreScript('jquery')
            ->registerCssFile($url)
            ->registerScriptFile($baseUrl . $cloudJs)
            ->registerScript(__CLASS__ . '#' . $id, "jQuery('#$id').jQCloud($wordList);");

        echo CHtml::tag($this->tagName, $this->htmlOptions);

    }
}

<?php

/**
 * YdFancyBox widget class file.
 *
 * YdFancyBox extends CWidget and implements a base class for a fancybox widget.
 * More about fancybox can be found at http://fancybox.net/.
 *
 * @author Ahmed Sharaf <sharaf.developer@gmail.com>
 * @copyright (c) 2013, Ahmed Sharaf
 * MADE IN EGYPT
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 * @refrences Otaviani Vidal <thiagovidal@othys.com>
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.widgets
 */

class YdFancyBox extends CWidget
{

    /**
     * @var the id of the widget
     */
    public $id;

    /**
     * @var string the taget element on DOM
     */
    public $target = '.fancybox';

    /**
     * @var bool whether to enable the easing functions. You must set the eansing on $config.
     */
    public $easingEnabled = false;

    /**
     * @var bool whether to enable mouse interaction
     */
    public $mouseEnabled = true;

    /**
     * @var bool whether to enable helpers interaction
     */
    public $helpersEnabled = false;

    /**
     * @var array of config settings for fancybox
     */
    public $config = array();

    /**
     *
     */
    public function init()
    {
        // if not informed will generate Yii defaut generated id
        if (!isset($this->id))
            $this->id = $this->getId();
        // publish the required assets
        $this->publishAssets();
    }

    /**
     *
     */
    public function run()
    {
        $config = CJavaScript::encode($this->config);
        Yii::app()->clientScript->registerScript($this->getId(), "
			$('$this->target').fancybox($config);
		");
    }

    /**
     *
     */
    public function publishAssets()
    {
        $cs = Yii::app()->getClientScript();
        $baseUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets.fancybox'), true, -1, YII_DEBUG);

        $cs->registerCssFile($baseUrl . '/css/jquery.fancybox.css');
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($baseUrl . '/js/jquery.fancybox.pack.js', CClientScript::POS_END);
        // if mouse actions enbled register the js
        if ($this->mouseEnabled) {
            $cs->registerScriptFile($baseUrl . '/js/jquery.mousewheel-3.0.6.pack.js', CClientScript::POS_END);
        }
        // if easing enbled register the js
        if ($this->easingEnabled) {
            $cs->registerScriptFile($baseUrl . '/js/jquery.easing-1.3.pack.js', CClientScript::POS_END);
        }
        // if easing enbled register the js & css
        if ($this->helpersEnabled) {
            $cs->registerCssFile($baseUrl . '/css/jquery.fancybox-buttons.css');
            $cs->registerCssFile($baseUrl . '/css/jquery.fancybox-thumbs.css');
            $cs->registerScriptFile($baseUrl . '/js/jquery.fancybox-buttons.js', CClientScript::POS_END);
            $cs->registerScriptFile($baseUrl . '/js/jquery.fancybox-media.js', CClientScript::POS_END);
            $cs->registerScriptFile($baseUrl . '/js/jquery.fancybox-thumbs.js', CClientScript::POS_END);
        }
    }

}
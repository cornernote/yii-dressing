<?php
/**
 * @var $this YdWebController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-skeleton
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

// load here so modals don't have to load it
Yii::app()->getClientScript()->registerCoreScript('yiiactiveform');

// modal for popups
$this->widget('dressing.widgets.YdModal');

// fancybox for popups
$this->widget('dressing.components.YdFancyBox');

// qtip for tooltips
$this->widget('dressing.widgets.YdQTip');


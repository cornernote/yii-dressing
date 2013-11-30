<?php

/**
 * YdClueTip
 *
 * @package dressing.widgets
 */
class YdClueTip extends CWidget
{
    /**
     * @var string
     */
    public $target = 'a.tips';

    /**
     * @var string
     */
    public $config = array();

    /**
     *
     */
    public function init()
    {
        $this->publishAssets();
    }

    /**
     * function to publish and register assets on page
     */
    public function publishAssets()
    {
        $cs = Yii::app()->getClientScript();
        $baseUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets.jquery-cluetip'), true, -1, YII_DEBUG);
        $cs->registerScriptFile($baseUrl . '/lib/jquery.hoverIntent.js');
        $cs->registerScriptFile($baseUrl . '/jquery.cluetip.min.js');
        $cs->registerCssFile($baseUrl . '/jquery.cluetip.css');
        $cs->registerScript('cluetip', '$("' . $this->target . '").cluetip(' . json_encode($this->config) . ');', CClientScript::POS_READY);
    }

}
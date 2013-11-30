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

    // function to publish and register assets on page
    /**
     *
     */
    public function publishAssets()
    {
        $cs = Yii::app()->getClientScript();
        $baseUrl = Yii::app()->dressing->getAssetsUrl();
        $cs->registerScriptFile($baseUrl . '/jquery-cluetip/lib/jquery.hoverIntent.js');
        $cs->registerScriptFile($baseUrl . '/jquery-cluetip/jquery.cluetip.min.js');
        $cs->registerCssFile($baseUrl . '/jquery-cluetip/jquery.cluetip.css');
        $cs->registerScript('cluetip', '$("' . $this->target . '").cluetip(' . json_encode($this->config) . ');', CClientScript::POS_READY);
    }
}
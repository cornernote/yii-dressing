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
        $cs = Yii::app()->clientScript;
        $cs->registerPackage('jquery-cluetip');
        $cs->registerScript('cluetip', '$("' . $this->target . '").cluetip(' . json_encode($this->config) . ');', CClientScript::POS_READY);
    }
}
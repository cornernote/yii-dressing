<?php

/**
 *
 */
class YdFontAwesome extends CWidget
{

    /**
     *
     */
    public function init()
    {
        $baseUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('vendor.fortawesome.font-awesome'), false, -1, YII_DEBUG);
        $clientScript = Yii::app()->clientScript;
        $clientScript->registerCssFile($baseUrl . '/css/font-awesome.min.css');
        parent::init();
    }

}
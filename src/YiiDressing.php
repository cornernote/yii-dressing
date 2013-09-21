<?php
/**
 * In configuration file main.php add this lines of code:
 * 'preload'=>array('yiiDressing',...),
 *  ...
 * 'components'=>array(
 *   ...
 *   'yiiDressing'=>array(
 *     'class'=>'YiiDressing',
 *   ),
 */
class YiiDressing extends CApplicationComponent
{

    /**
     * @var string Path to the assets
     */
    public $assetPath;

    /**
     *
     */
    public function init()
    {
        parent::init();

        // import classes
        Yii::import('dressing.components.*');
        Yii::import('dressing.helpers.*');
        Yii::import('dressing.models.*');

        // start the audit
        YdAudit::findCurrent();

        // publish assets
        $this->assetPath = Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets.yii-dressing'), true, -1, YII_DEBUG);
        Yii::app()->clientScript->registerCSSFile($this->assetPath . '/css/yii-dressing.css');
    }
}

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
     *
     */
    public function init()
    {
        parent::init();

        // import classes
        Yii::import('dressing.components.*');
        Yii::import('dressing.helpers.*');
        Yii::import('dressing.models.*');
    }
}

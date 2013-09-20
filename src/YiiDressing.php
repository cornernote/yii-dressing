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

        // set an alias to components
        Yii::setPathOfAlias('actions', Yii::app()->getBasePath() . '/components/actions');
        Yii::setPathOfAlias('behaviors', Yii::app()->getBasePath() . '/components/behaviors');
        Yii::setPathOfAlias('validators', Yii::app()->getBasePath() . '/components/validators');
        Yii::setPathOfAlias('widgets', Yii::app()->getBasePath() . '/components/widgets');
        Yii::setPathOfAlias('core', $_ENV['_core']['path']);

        // set default php settings
        date_default_timezone_set(Setting::item('timezone'));
        $timeLimit = isCli() ? 5 : param('time_limit');
        set_time_limit($timeLimit);
        ini_set('max_execution_time', $timeLimit);
        ini_set('memory_limit', Setting::item('memory_limit'));
        ini_set('xdebug.max_nesting_level', 200);

        // start the audit
        Audit::findCurrent();
    }
}

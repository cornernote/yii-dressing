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
     * @var bool
     */
    public $enableCdn = false;

    /**
     * @var bool
     */
    public $minify = false;

    /**
     * @var array
     */
    public $tableMap = array();

    /**
     * @var string Url to the assets
     */
    private $_assetUrl;

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

        // map tables
        $this->tableMap = array_merge($this->tableMap, array(
            'YdAttachment' => 'attachment',
            'YdAudit' => 'audit',
            'YdAuditTrail' => 'audit_trail',
            'YdContactUs' => 'contact_us',
            'YdEmailSpool' => 'email_spool',
            'YdEmailTemplate' => 'email_template',
            'YdLookup' => 'lookup',
            'YdMenu' => 'menu',
            'YdRole' => 'role',
            'YdSetting' => 'setting',
            'YdToken' => 'token',
            'YdUser' => 'user',
            'YdUserToRole' => 'user_to_role',
        ));

        $this->registerScripts();

    }

    /**
     * @return string
     */
    public function getAssetsUrl()
    {
        if ($this->_assetUrl)
            return $this->_assetUrl;
        return $this->_assetUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets'), true, -1, YII_DEBUG);
    }

    /**
     *
     */
    public function registerScripts()
    {
        // register style
        Yii::app()->clientScript->registerCSSFile($this->assetUrl . '/yii-dressing/css/yii-dressing.css');
        // dropdown JS doesn't work on iPad - https://github.com/twitter/bootstrap/issues/2975#issuecomment-6659992
        Yii::app()->clientScript->registerScript('bootstrap-dropdown-fix', "$('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { e.stopPropagation(); });", CClientScript::POS_END);
    }

}

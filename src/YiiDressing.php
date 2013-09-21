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
     * @var string Url to the assets
     */
    public $assetUrl;

    /**
     * @var array
     */
    public $tableMap = array();

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

    }

}

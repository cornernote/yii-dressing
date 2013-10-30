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
 *
 * @author Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing
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
     * @var array
     */
    public $packages = array();

    /**
     * @var string Url to the assets
     */
    private $_assetsUrl;

    /**
     * @return string
     */
    public static function getVersion()
    {
        return 'dev';
        //return '0.0.1';
    }

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

        // map tables
        $this->tableMap = array_merge($this->tableMap, array(
            'YdAttachment' => 'attachment',
            'YdAudit' => 'audit',
            'YdAuditTrail' => 'audit_trail',
            'YdContactUs' => 'contact_us',
            'YdEmailSpool' => 'email_spool',
            'YdEmailTemplate' => 'email_template',
            'YdLookup' => 'lookup',
            'YdSiteMenu' => 'site_menu',
            'YdRole' => 'role',
            'YdSetting' => 'setting',
            'YdToken' => 'token',
            'YdUser' => 'user',
            'YdUserToRole' => 'user_to_role',
        ));

        // add packages and register scripts
        if (!YdHelper::isCli()) {
            $this->addPackages();
            $this->registerScripts();
        }
    }

    /**
     * @return string
     */
    public function addPackages()
    {
        $packages = require(Yii::getPathOfAlias('dressing') . '/packages.php');

        $this->packages = CMap::mergeArray(
            $packages,
            $this->packages
        );

        foreach ($this->packages as $name => $definition) {
            Yii::app()->clientScript->addPackage($name, $definition);
        }
    }

    /**
     * @return string
     */
    public function getAssetsUrl()
    {
        if ($this->_assetsUrl)
            return $this->_assetsUrl;
        return $this->_assetsUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets'), true, -1, YII_DEBUG);
    }

    /**
     *
     */
    public function registerScripts()
    {
        // register style
        Yii::app()->clientScript->registerCSSFile($this->getAssetsUrl() . '/yii-dressing/css/yii-dressing.css');
        // dropdown JS doesn't work on iPad - https://github.com/twitter/bootstrap/issues/2975#issuecomment-6659992
        Yii::app()->clientScript->registerScript('bootstrap-dropdown-fix', "$('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { e.stopPropagation(); });", CClientScript::POS_END);
    }

}

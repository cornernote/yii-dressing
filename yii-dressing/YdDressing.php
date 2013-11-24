<?php
/**
 * YdDressing is the main application component for YiiDressing.
 *
 * It defines the options available to YiiDressing and several other components as well as including table mapping
 * and asset package definitions.
 *
 * If you are not bootstrapping your application with YdBase then you will need to add the following to your Yii config:
 * <pre>
 * 'preload'=>array('dressing', ... ),
 * 'components'=>array(
 *     'dressing'=>array(
 *         'class'=>'path.to.YdDressing',
 *     ),
 *     ...
 * ),
 * </pre>
 *
 * @author Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing
 */
class YdDressing extends CApplicationComponent
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
     * @var array Map of tables used by Yii Dressing.
     */
    public $tableMap = array();

    /**
     * @var bool Enable or disable recaptcha.
     */
    public $recaptcha = false;

    /**
     * @var string
     */
    public $recaptchaPrivate = '6LeBItQSAAAAALA4_G05e_-fG5yH_-xqQIN8AfTD';

    /**
     * @var string
     */
    public $recaptchaPublic = '6LeBItQSAAAAAG_umhiD0vyxXbDFbVMPA0kxZUF6';

    /**
     * @var bool Default setting for remember me checkbox on login page
     */
    public $defaultRememberMe = true;

    /**
     * @var bool Enable or disable auditing.
     */
    public $audit = false;

    /**
     * @var array
     */
    public $auditUserRelation = array(
        'CBelongsToRelation',
        'YdUser',
        'user_id',
    );

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

        // set alias
        if (!Yii::getPathOfAlias('dressing'))
            Yii::setPathOfAlias('dressing', dirname(__FILE__));

        // import classes
        Yii::import('dressing.components.*');
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
        if (!YII_DRESSING_CLI) {
            $this->addPackages();
            $this->registerScripts();
        }
    }

    /**
     * @return string
     */
    public function addPackages()
    {
        $packages = array(
            'signature-pad' => array(
                'depends' => array('jquery'),
                'baseUrl' => $this->getAssetsUrl() . '/signature-pad/',
                'css' => array($this->minify ? 'jquery.signaturepad.yii-dressing.min.css' : 'jquery.signaturepad.yii-dressing.css'),
                'js' => array($this->minify ? 'jquery.signaturepad.min.js' : 'jquery.signaturepad.js')
            ),
            'jquery-cluetip' => array(
                'depends' => array('jquery'),
                'baseUrl' => $this->getAssetsUrl() . '/jquery-cluetip/',
                'css' => array('jquery.cluetip.css'),
                'js' => array(
                    'lib/jquery.hoverIntent.js',
                    $this->minify ? 'jquery.cluetip.min.js' : 'jquery.cluetip.js',
                )
            ),
        );
        foreach ($packages as $name => $definition) {
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

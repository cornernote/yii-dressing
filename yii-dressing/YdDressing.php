<?php
/**
 * YdDressing is the main application component for YiiDressing.
 *
 * It defines the options available to YiiDressing and several other components as well as including table mapping
 * and asset package definitions.
 *
 * If you are not bootstrapping your application with YdBase then you will need to add the following to your Yii config:
 * <pre>
 * 'components'=>array(
 *     'dressing'=>array(
 *         'class'=>'path.to.yii-dressing.YdDressing',
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
     * @var array Map of model info including relations and behaviors.
     */
    public $modelMap = array();

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
     * @var string Url to the assets
     */
    private $_assetsUrl;

    /**
     * @return string
     */
    public static function getVersion()
    {
        //return 'dev';
        return '0.1.0';
    }

    /**
     *
     */
    public function init()
    {
        // set alias
        if (!Yii::getPathOfAlias('dressing'))
            Yii::setPathOfAlias('dressing', dirname(__FILE__));

        // import classes
        Yii::import('dressing.components.*');
        Yii::import('dressing.models.*');

        // map models
        $this->mapModels();

        // add packages and register scripts
        if (!YII_DRESSING_CLI) {
            $this->addPackages();
            $this->registerScripts();
        }

        // init parent
        parent::init();
    }

    /**
     *
     */
    public function mapModels()
    {
        $this->modelMap = array_merge($this->modelMap, array(
            'YdAudit' => array(
                'relations' => array(
                    'user' => array(
                        'CBelongsToRelation',
                        'YdUser',
                        'user_id',
                    ),
                    'auditTrail' => array(
                        'CHasManyRelation',
                        'YdAuditTrail',
                        'audit_id',
                    ),
                    'auditTrailCount' => array(
                        'CStatRelation',
                        'YdAuditTrail',
                        'audit_id',
                    ),
                ),
            ),
            'YdAuditTrail' => array(
                'relations' => array(
                    'user' => array(
                        'CBelongsToRelation',
                        'YdUser',
                        'user_id',
                    ),
                    'audit' => array(
                        'CBelongsToRelation',
                        'YdAudit',
                        'audit_id',
                    ),
                ),
            ),
            'YdContactUs' => array(
                'behaviors' => array(
                    'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
                    'TimestampBehavior' => 'dressing.behaviors.YdTimestampBehavior',
                ),
            ),
            'YdEmailSpool' => array(
                'attachment' => array(
                    'relations' => array(
                        'CHasManyRelation',
                        'YdAttachment',
                        'model_id',
                        'condition' => 'attachment.model=:model AND deleted IS NULL',
                        'params' => array(':model' => 'YdEmailSpool'),
                        'order' => 'weight',
                    ),
                ),
                'behaviors' => array(
                    'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
                    'SoftDeleteBehavior' => 'dressing.behaviors.YdSoftDeleteBehavior',
                    'TimestampBehavior' => 'dressing.behaviors.YdTimestampBehavior',
                ),
            ),
            'YdEmailTemplate' => array(
                'behaviors' => array(
                    'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
                ),
            ),
            'YdLookup' => array(
                'behaviors' => array(
                    'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
                    'TimestampBehavior' => 'dressing.behaviors.YdTimestampBehavior',
                    'SoftDeleteBehavior' => 'dressing.behaviors.YdSoftDeleteBehavior',
                ),
            ),
            'YdSetting' => array(
                'behaviors' => array(
                    'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
                ),
            ),
            'YdSiteMenu' => array(
                'relations' => array(
                    'child' => array(
                        'CHasManyRelation',
                        'YdSiteMenu',
                        'parent_id',
                        'condition' => 'child.enabled=1 AND child.deleted IS NULL',
                        'order' => 'sort_order ASC, label ASC',
                    ),
                    'parent' => array(
                        'CBelongsToRelation',
                        'YdSiteMenu',
                        'parent_id',
                    ),
                ),
                'behaviors' => array(
                    'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
                    'SoftDeleteBehavior' => 'dressing.behaviors.YdSoftDeleteBehavior',
                    'TimestampBehavior' => 'dressing.behaviors.YdTimestampBehavior',
                ),
            ),
            'YdToken' => array(
                'behaviors' => array(
                    'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
                ),
            ),
            'YdUser' => array(
                'relations' => array(
                    'role' => array(
                        'CManyManyRelation',
                        'YdRole',
                        'user_to_role(user_id, role_id)',
                    ),
                    'userToRole' => array(
                        'CManyManyRelation',
                        'YdUserToRole',
                        'user_id',
                    ),
                ),
                'behaviors' => array(
                    'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
                    'SoftDeleteBehavior' => 'dressing.behaviors.YdSoftDeleteBehavior',
                    'TimestampBehavior' => 'dressing.behaviors.YdTimestampBehavior',
                    'EavBehavior' => array(
                        'class' => 'dressing.behaviors.YdEavBehavior',
                        'tableName' => 'user_eav',
                    ),
                ),
            ),
            'YdUserToRole' => array(
                'behaviors' => array(
                    'AuditBehavior' => array(
                        'class' => 'dressing.behaviors.YdAuditBehavior',
                        'additionalAuditModels' => array(
                            'User' => 'user_id',
                            //'Role' => 'role_id',
                        ),
                    ),
                ),
            ),
        ));
    }

    /**
     * Defines packages that can be called later using:
     * <pre>
     * Yii::app()->clientScript->registerPackage($name)
     * </pre>
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
     * Returns the url for YiiDressing assets
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
        // fixed: https://github.com/twbs/bootstrap/issues/2975#issuecomment-11166414
        // Yii::app()->clientScript->registerScript('bootstrap-dropdown-fix', "$('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { e.stopPropagation(); });", CClientScript::POS_END);
    }

}

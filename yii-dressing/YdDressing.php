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
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing
 */
class YdDressing extends CApplicationComponent
{

    /**
     * @var array Map of model info including relations and behaviors.
     */
    public $modelMap = array();

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
        return '0.4.0';
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

        // init parent
        parent::init();
    }

    /**
     *
     */
    public function mapModels()
    {
        $this->modelMap = array_merge(array(
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
                'behaviors' => array(
                    'LinkBehavior' => array(
                        'class' => 'dressing.behaviors.YdLinkBehavior',
                        'controllerName' => 'audit',
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
                    'LinkBehavior' => array(
                        'class' => 'dressing.behaviors.YdLinkBehavior',
                        'controllerName' => 'contactUs',
                    ),
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
                    'LinkBehavior' => array(
                        'class' => 'dressing.behaviors.YdLinkBehavior',
                        'controllerName' => 'emailSpool',
                    ),
                ),
            ),
            'YdEmailTemplate' => array(
                'behaviors' => array(
                    'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
                    'LinkBehavior' => array(
                        'class' => 'dressing.behaviors.YdLinkBehavior',
                        'controllerName' => 'emailTemplate',
                    ),
                ),
            ),
            'YdLookup' => array(
                'behaviors' => array(
                    'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
                    'TimestampBehavior' => 'dressing.behaviors.YdTimestampBehavior',
                    'SoftDeleteBehavior' => 'dressing.behaviors.YdSoftDeleteBehavior',
                    'LinkBehavior' => array(
                        'class' => 'dressing.behaviors.YdLinkBehavior',
                        'controllerName' => 'lookup',
                    ),
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
                    'LinkBehavior' => array(
                        'class' => 'dressing.behaviors.YdLinkBehavior',
                        'controllerName' => 'siteMenu',
                    ),
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
                    'LinkBehavior' => array(
                        'class' => 'dressing.behaviors.YdLinkBehavior',
                        'controllerName' => 'user',
                    ),
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
        ), $this->modelMap);
    }

    /**
     * Returns the url for YiiDressing assets
     * @return string
     */
    public function getAssetsUrl()
    {
        if ($this->_assetsUrl)
            return $this->_assetsUrl;
        return $this->_assetsUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets.yii-dressing'), true, -1, YII_DEBUG);
    }

}

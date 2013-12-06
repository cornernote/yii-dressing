<?php
/**
 * @var $this RoleController
 * @var $role YdRole
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

$this->pageTitle = $this->pageHeading = $role->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'Log');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Roles')] = Yii::app()->user->getState('index.role', array('/role/index'));
$this->breadcrumbs[$role->getName()] = $role->getUrl();
$this->breadcrumbs[] = Yii::t('dressing', 'Log');

$this->renderPartial('/role/_menu', array(
    'role' => $role,
));
$this->renderPartial('/auditTrail/_log', array(
    'model' => $role,
));

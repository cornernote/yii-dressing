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

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'Create');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Roles')] = Yii::app()->user->getState('index.role', array('/role/index'));
$this->breadcrumbs[] = Yii::t('dressing', 'Create');

$this->renderPartial('/role/_menu', array(
    'role' => $role,
));
$this->renderPartial('/role/_form', array(
    'role' => $role,
));

<?php
/**
 * @var $this RoleController
 * @var $role YdRole
 */

$this->pageTitle = $this->pageHeading = $role->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'Log');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Roles')] = Yii::app()->user->getState('index.role', array('/role/index'));
$this->breadcrumbs[$role->getName()] = $role->getUrl();
$this->breadcrumbs[] = Yii::t('dressing', 'Log');

$this->renderPartial('dressing.views.role._menu', array(
    'role' => $role,
));
$this->renderPartial('dressing.views.auditTrail._log', array(
    'model' => $role,
));

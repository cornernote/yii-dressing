<?php
/**
 * @var $this RoleController
 * @var $role YdRole
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'Create');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Roles')] = Yii::app()->user->getState('index.role', array('/role/index'));
$this->breadcrumbs[] = Yii::t('dressing', 'Create');

$this->renderPartial('dressing.views.role._menu', array(
    'role' => $role,
));
$this->renderPartial('dressing.views.role._form', array(
    'role' => $role,
));

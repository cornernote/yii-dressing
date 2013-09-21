<?php
/**
 * @var $this RoleController
 * @var $role YdRole
 */

$this->pageTitle = $this->pageHeading = $role->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'View');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Roles')] = Yii::app()->user->getState('index.role', array('/role/index'));
$this->breadcrumbs[] = $role->getName();

$this->renderPartial('dressing.views.role._menu', array(
    'role' => $role,
));

$attributes = array();
$attributes[] = array(
    'name' => 'id',
);
$attributes[] = array(
    'name' => 'name',
);
$attributes[] = array(
    'name' => 'created',
);
$attributes[] = array(
    'name' => 'modified',
);

$this->widget('widgets.DetailView', array(
    'data' => $role,
    'attributes' => $attributes,
));

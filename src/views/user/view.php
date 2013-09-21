<?php
/**
 * @var $this UserController
 * @var $user YdUser
 */
$this->pageTitle = $this->pageHeading = $user->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'View');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Users')] = Yii::app()->user->getState('index.user', array('/user/index'));
$this->breadcrumbs[] = $user->getName();

$this->renderPartial('dressing.views.user._menu', array(
    'user' => $user,
));

$attributes = array();
$attributes[] = 'id';
$attributes[] = 'username';
$attributes[] = 'name';
$attributes[] = array(
    'name' => 'email',
    'value' => CHtml::link($user->email, 'mailto:' . $user->email),
    'type' => 'raw',
);
$attributes[] = 'phone';
$attributes[] = array(
    'label' => Yii::t('dressing', 'Roles'),
    'value' => implode(', ', CHtml::listData($user->role, 'id', 'name')),
);
$attributes[] = 'created';
$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $user,
    'attributes' => $attributes,
));


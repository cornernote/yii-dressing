<?php
/**
 * @var $this UserController
 * @var $user User
 */
$this->pageTitle = $this->pageHeading = $user->getName() . ' - ' . $this->getName() . ' ' . t('View');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.user', array('/user/index'));
$this->breadcrumbs[] = $user->getName();

$this->renderPartial('_menu', array(
    'user' => $user,
));

$attributes = array();
$attributes[] = 'id';
$attributes[] = 'username';
$attributes[] = 'name';
$attributes[] = array(
    'name' => 'email',
    'value' => l($user->email, 'mailto:' . $user->email),
    'type' => 'raw',
);
$attributes[] = 'phone';
$attributes[] = array(
    'label' => t('Roles'),
    'value' => implode(', ', CHtml::listData($user->role, 'id', 'name')),
);
$attributes[] = 'created';
$this->widget('widgets.DetailView', array(
    'data' => $user,
    'attributes' => $attributes,
));


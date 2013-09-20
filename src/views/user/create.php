<?php
/**
 * @var $this UserController
 * @var $user User
 */
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('Create');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.user', array('/user/index'));
$this->breadcrumbs[] = t('Create');

$this->renderPartial('_menu', array(
    'user' => $user,
));
$this->renderPartial('_form', array(
    'user' => $user,
));
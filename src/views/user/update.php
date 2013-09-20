<?php
/**
 * @var $this UserController
 * @var $user User
 */
$this->pageTitle = $this->pageHeading = $user->getName() . ' - ' . $this->getName() . ' ' . t('Update');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.user', array('/user/index'));
$this->breadcrumbs[$user->getName()] = $user->getLink();
$this->breadcrumbs[] = t('Update');

$this->renderPartial('_menu', array(
    'user' => $user,
));
$this->renderPartial('_form', array(
    'user' => $user,
));

<?php
/**
 * @var $this UserController
 * @var $user User
 */
$this->pageTitle = $this->pageHeading = $user->getName() . ' - ' . $this->getName() . ' ' . t('Log');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.user', array('/user/index'));
$this->breadcrumbs[$user->getName()] = $user->getLink();
$this->breadcrumbs[] = t('Log');

$this->renderPartial('_menu', array(
    'user' => $user,
));
$this->renderPartial('/auditTrail/_log', array(
    'model' => $user,
));
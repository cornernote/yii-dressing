<?php
/**
 * @var $this UserController
 * @var $user YdUser
 */
$this->pageTitle = $this->pageHeading = $user->getName() . ' - ' . $this->getName() . ' ' . t('Update');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.user', array('/user/index'));
$this->breadcrumbs[$user->getName()] = $user->getLink();
$this->breadcrumbs[] = t('Update');

$this->renderPartial('dressing.views.user._menu', array(
    'user' => $user,
));
$this->renderPartial('dressing.views.user._form', array(
    'user' => $user,
));

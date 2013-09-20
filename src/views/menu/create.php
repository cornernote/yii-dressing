<?php
/**
 * @var $this MenuController
 * @var $menu Menu
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('Create');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.menu', array('/menu/index'));
$this->breadcrumbs[] = t('Create');

$this->renderPartial('_menu', array(
    'menu' => $menu,
));
$this->renderPartial('_form', array(
    'menu' => $menu,
));

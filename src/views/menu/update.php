<?php
/**
 * @var $this MenuController
 * @var $menu Menu
 */

$this->pageTitle = $this->pageHeading = $menu->getName() . ' - ' . $this->getName() . ' ' . t('Update');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.menu', array('/menu/index'));
$this->breadcrumbs[$menu->getName()] = $menu->getLink();
$this->breadcrumbs[] = t('Update');

$this->renderPartial('_menu', array(
    'menu' => $menu,
));
$this->renderPartial('_form', array(
    'menu' => $menu,
));

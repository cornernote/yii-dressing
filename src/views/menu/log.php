<?php
/**
 * @var $this MenuController
 * @var $menu Menu
 */

$this->pageTitle = $this->pageHeading = $menu->getName() . ' - ' . $this->getName() . ' ' . t('Log');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.menu', array('/menu/index'));
$this->breadcrumbs[$menu->getName()] = $menu->getLink();
$this->breadcrumbs[] = t('Log');

$this->renderPartial('_menu', array(
    'menu' => $menu,
));
$this->renderPartial('/auditTrail/_log', array(
    'model' => $menu,
));

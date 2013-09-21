<?php
/**
 * @var $this MenuController
 * @var $menu YdMenu
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('Create');

$this->breadcrumbs[t('Tools')] = array('/tool/index');
$this->breadcrumbs[t('Menus')] = user()->getState('index.menu', array('/menu/index'));
$this->breadcrumbs[] = t('Create');

$this->renderPartial('dressing.views.menu._menu', array(
    'menu' => $menu,
));
$this->renderPartial('dressing.views.menu._form', array(
    'menu' => $menu,
));

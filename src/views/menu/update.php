<?php
/**
 * @var $this MenuController
 * @var $menu YdMenu
 */

$this->pageTitle = $this->pageHeading = $menu->getName() . ' - ' . $this->getName() . ' ' . t('Update');

$this->breadcrumbs[t('Tools')] = array('/tool/index');
$this->breadcrumbs[t('Menus')] = user()->getState('index.menu', array('/menu/index'));
$this->breadcrumbs[$menu->getName()] = $menu->getLink();
$this->breadcrumbs[] = t('Update');

$this->renderPartial('dressing.views.lookup._menu', array(
    'menu' => $menu,
));
$this->renderPartial('dressing.views.lookup._form', array(
    'menu' => $menu,
));

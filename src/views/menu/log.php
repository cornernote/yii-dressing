<?php
/**
 * @var $this MenuController
 * @var $menu YdMenu
 */

$this->pageTitle = $this->pageHeading = $menu->getName() . ' - ' . $this->getName() . ' ' . t('Log');

$this->breadcrumbs[t('Tools')] = array('/tool/index');
$this->breadcrumbs[t('Menus')] = Yii::app()->user->getState('index.menu', array('/menu/index'));
$this->breadcrumbs[$menu->getName()] = $menu->getLink();
$this->breadcrumbs[] = t('Log');

$this->renderPartial('dressing.views.menu._menu', array(
    'menu' => $menu,
));
$this->renderPartial('dressing.views.auditTrail._log', array(
    'model' => $menu,
));

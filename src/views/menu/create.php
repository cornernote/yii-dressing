<?php
/**
 * @var $this MenuController
 * @var $menu YdMenu
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'Create');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Menus')] = Yii::app()->user->getState('index.menu', array('/menu/index'));
$this->breadcrumbs[] = Yii::t('dressing', 'Create');

$this->renderPartial('dressing.views.menu._menu', array(
    'menu' => $menu,
));
$this->renderPartial('dressing.views.menu._form', array(
    'menu' => $menu,
));

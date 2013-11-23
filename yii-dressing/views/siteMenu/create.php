<?php
/**
 * @var $this YdSiteMenuController
 * @var $menu YdSiteMenu
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'Create');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Site Menus')] = Yii::app()->user->getState('index.siteMenu', array('/siteMenu/index'));
$this->breadcrumbs[] = Yii::t('dressing', 'Create');

$this->renderPartial('dressing.views.siteMenu._menu', array(
    'menu' => $menu,
));
$this->renderPartial('dressing.views.siteMenu._form', array(
    'menu' => $menu,
));

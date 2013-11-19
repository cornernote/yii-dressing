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

$this->pageTitle = $this->pageHeading = $menu->getName() . ' - ' . $this->getName() . ' ' . t('Log');

$this->breadcrumbs[t('Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Site Menus')] = Yii::app()->user->getState('index.siteMenu', array('/siteMenu/index'));
$this->breadcrumbs[$menu->getName()] = $menu->getLink();
$this->breadcrumbs[] = t('Log');

$this->renderPartial('dressing.views.siteMenu._menu', array(
    'menu' => $menu,
));
$this->renderPartial('dressing.views.auditTrail._log', array(
    'model' => $menu,
));

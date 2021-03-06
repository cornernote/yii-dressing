<?php
/**
 * @var $this ToolController
 */

$this->pageTitle = Yii::t('dressing', 'Tools');

echo '<h2>' . t('Manage') . '</h2>';
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_PILLS,
    'items' => SiteMenu::getItemsFromMenu('Manage', SiteMenu::MENU_ADMIN),
));

echo '<h2>' . t('Settings') . '</h2>';
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_PILLS,
    'items' => SiteMenu::getItemsFromMenu('Settings', SiteMenu::MENU_ADMIN),
));

echo '<h2>' . t('Reports') . '</h2>';
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_PILLS,
    'items' => SiteMenu::getItemsFromMenu('Reports', SiteMenu::MENU_ADMIN),
));

echo '<h2>' . t('Logs') . '</h2>';
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_PILLS,
    'items' => SiteMenu::getItemsFromMenu('Logs', SiteMenu::MENU_ADMIN),
));

echo '<h2>' . t('Tools') . '</h2>';
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_PILLS,
    'items' => SiteMenu::getItemsFromMenu('Tools', SiteMenu::MENU_ADMIN),
));

<?php
/**
 * @var $this ToolController
 */

$this->pageTitle = Yii::t('dressing', 'Tools');

echo '<h2>' . t('Manage') . '</h2>';
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_PILLS,
    'items' => YdSiteMenu::getItemsFromMenu('Manage', YdSiteMenu::MENU_ADMIN),
));

echo '<h2>' . t('Settings') . '</h2>';
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_PILLS,
    'items' => YdSiteMenu::getItemsFromMenu('Settings', YdSiteMenu::MENU_ADMIN),
));

echo '<h2>' . t('Reports') . '</h2>';
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_PILLS,
    'items' => YdSiteMenu::getItemsFromMenu('Reports', YdSiteMenu::MENU_ADMIN),
));

echo '<h2>' . t('Logs') . '</h2>';
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_PILLS,
    'items' => YdSiteMenu::getItemsFromMenu('Logs', YdSiteMenu::MENU_ADMIN),
));

echo '<h2>' . t('Tools') . '</h2>';
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_PILLS,
    'items' => YdSiteMenu::getItemsFromMenu('Tools', YdSiteMenu::MENU_ADMIN),
));

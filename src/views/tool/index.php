<?php
/**
 * @var $this ToolController
 */

$this->pageTitle = $this->pageHeading = t('Tools');
//$this->breadcrumbs = array(t('Tools'));
//$this->menu = SiteMenu::getItemsFromMenu('User');

echo '<h2>' . t('Manage') . '</h2>';
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'pills',
    'items' => SiteMenu::getItemsFromMenu('Manage', SiteMenu::MENU_ADMIN),
));

echo '<h2>' . t('Settings') . '</h2>';
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'pills',
    'items' => SiteMenu::getItemsFromMenu('Settings', SiteMenu::MENU_ADMIN),
));

echo '<h2>' . t('Logs') . '</h2>';
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'pills',
    'items' => SiteMenu::getItemsFromMenu('Logs', SiteMenu::MENU_ADMIN),
));

echo '<h2>' . t('Tools') . '</h2>';
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'pills',
    'items' => SiteMenu::getItemsFromMenu('Tools', SiteMenu::MENU_ADMIN),
));

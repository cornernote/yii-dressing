<?php
/**
 * @var $this UserController
 * @var $user YdUser
 */

$this->pageTitle = $this->pageHeading = t('Tools');
$this->breadcrumbs = array(t('Tools'));

$this->menu = YdMenu::getItemsFromMenu('User');

$items = YdMenu::getItemsFromMenu('Admin');
foreach ($items as $item) {
    echo '<h2>' . $item['label'] . '</h2>';
    $this->widget('bootstrap.widgets.TbMenu', array(
        'type' => 'pills',
        'items' => $item['items'],
    ));
}

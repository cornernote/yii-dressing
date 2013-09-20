<?php
/**
 * @var $this MenuController
 * @var $menu Menu
 */

// index
if ($this->action->id == 'index') {
    $this->menu = Menu::getItemsFromMenu('System');
    return; // no more links
}

// create
if ($menu->isNewRecord) {
    $this->menu[] = array(
        'label' => t('Create'),
        'url' => array('/menu/create'),
    );
    return; // no more links
}

// view
$this->menu[] = array(
    'label' => t('View'),
    'url' => $menu->getUrl(),
);

// others
foreach ($menu->getDropdownLinkItems(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

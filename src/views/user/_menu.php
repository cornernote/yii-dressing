<?php
/**
 * @var $this UserController
 * @var $user YdUser
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdMenu::getItemsFromMenu('System');
    return; // no more links
}

// create
if ($user->isNewRecord) {
    $this->menu[] = array(
        'label' => t('Create'),
        'url' => array('/user/create'),
    );
    return; // no more links
}

// view
$this->menu[] = array(
    'label' => t('View'),
    'url' => $user->getUrl(),
);

// others
foreach ($user->getDropdownLinkItems(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

<?php
/**
 * @var $this RoleController
 * @var $role YdRole
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdMenu::getItemsFromMenu('Settings', YdMenu::MENU_ADMIN);
    return; // no more links
}

// create
if ($role->isNewRecord) {
    $this->menu[] = array(
        'label' => Yii::t('dressing', 'Create'),
        'url' => array('/role/create'),
    );
    return; // no more links
}

// view
$this->menu[] = array(
    'label' => Yii::t('dressing', 'View'),
    'url' => $role->getUrl(),
);

// others
foreach ($role->getMenuLinks(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

<?php
/**
 * @var $this UserController
 * @var $user YdUser
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdMenu::getItemsFromMenu('Manage', YdMenu::MENU_ADMIN);
    return; // no more links
}

// create
if ($user->isNewRecord) {
    $this->menu[] = array(
        'label' => Yii::t('dressing', 'Create'),
        'url' => array('/user/create'),
    );
    return; // no more links
}

// view
$this->menu[] = array(
    'label' => Yii::t('dressing', 'View'),
    'url' => $user->getUrl(),
);

// others
foreach ($user->getMenuLinks(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

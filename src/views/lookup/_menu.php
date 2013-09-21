<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdMenu::getItemsFromMenu('Settings', YdMenu::MENU_ADMIN);
    return; // no more links
}

// create
if ($lookup->isNewRecord) {
    $this->menu[] = array(
        'label' => Yii::t('dressing', 'Create'),
        'url' => array('/lookup/create'),
    );
    return; // no more links
}

// view
$this->menu[] = array(
    'label' => Yii::t('dressing', 'View'),
    'url' => $lookup->getUrl(),
);

// others
foreach ($lookup->getMenuLinks(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

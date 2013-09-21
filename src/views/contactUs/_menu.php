<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdMenu::getItemsFromMenu('Log', YdMenu::MENU_ADMIN);
    return; // no more links
}

// create
if ($contactUs->isNewRecord) {
    $this->menu[] = array(
        'label' => Yii::t('dressing', 'Create'),
        'url' => array('/contactUs/create'),
    );
    return; // no more links
}

// view
$this->menu[] = array(
    'label' => Yii::t('dressing', 'View'),
    'url' => $contactUs->getUrl(),
);

// others
foreach ($contactUs->getMenuLinks(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

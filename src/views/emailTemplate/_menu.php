<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate YdEmailTemplate
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdMenu::getItemsFromMenu('Settings', YdMenu::MENU_ADMIN);
    return; // no more links
}

// create
//if ($emailTemplate->isNewRecord) {
//    $this->menu[] = array(
//        'label' => Yii::t('dressing', 'Create'),
//        'url' => array('/emailTemplate/create'),
//    );
//    return; // no more links
//}

// view
$this->menu[] = array(
    'label' => Yii::t('dressing', 'View'),
    'url' => $emailTemplate->getUrl(),
);

// others
foreach ($emailTemplate->getMenuLinks(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

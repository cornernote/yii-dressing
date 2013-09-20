<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate EmailTemplate
 */

// index
if ($this->action->id == 'index') {
    $this->menu = Menu::getItemsFromMenu('System');
    return; // no more links
}

// create
//if ($emailTemplate->isNewRecord) {
//    $this->menu[] = array(
//        'label' => t('Create'),
//        'url' => array('/emailTemplate/create'),
//    );
//    return; // no more links
//}

// view
$this->menu[] = array(
    'label' => t('View'),
    'url' => $emailTemplate->getUrl(),
);

// others
foreach ($emailTemplate->getDropdownLinkItems(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

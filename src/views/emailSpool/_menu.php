<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool YdEmailSpool
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdMenu::getItemsFromMenu('Log');
    return; // no more links
}

// create
//if ($emailSpool->isNewRecord) {
//    $this->menu[] = array(
//        'label' => t('Create'),
//        'url' => array('/emailSpool/create'),
//    );
//    return; // no more links
//}

// view
$this->menu[] = array(
    'label' => t('View'),
    'url' => $emailSpool->getUrl(),
);

// others
foreach ($emailSpool->getDropdownLinkItems(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

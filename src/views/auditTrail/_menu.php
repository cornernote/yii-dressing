<?php
/**
 * @var $this AuditTrailController
 * @var $auditTrail AuditTrail
 */

// index
if ($this->action->id == 'index') {
    $this->menu = Menu::getItemsFromMenu('System');
    return; // no more links
}

// create
//if ($auditTrail->isNewRecord) {
//    $this->menu[] = array(
//        'label' => t('Create'),
//        'url' => array('/auditTrail/create'),
//    );
//    return; // no more links
//}

// view
$this->menu[] = array(
    'label' => t('View'),
    'url' => $auditTrail->getUrl(),
);

// others
foreach ($auditTrail->getDropdownLinkItems(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

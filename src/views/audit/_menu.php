<?php
/**
 * @var $this AuditController
 * @var $audit Audit
 */

// index
if ($this->action->id == 'index') {
    $this->menu = Menu::getItemsFromMenu('System');
    return; // no more links
}

// create
//if ($audit->isNewRecord) {
//    $this->menu[] = array(
//        'label' => t('Create'),
//        'url' => array('/audit/create'),
//    );
//    return; // no more links
//}

// view
$this->menu[] = array(
    'label' => t('View'),
    'url' => $audit->getUrl(),
);

// others
foreach ($audit->getDropdownLinkItems(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

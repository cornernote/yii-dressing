<?php
/**
 * @var $this AuditController
 * @var $audit YdAudit
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdMenu::getItemsFromMenu('System');
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

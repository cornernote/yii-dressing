<?php
/**
 * @var $this AuditTrailController
 * @var $auditTrail YdAuditTrail
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdMenu::getItemsFromMenu('Logs', YdMenu::MENU_ADMIN);
    return; // no more links
}

// create
//if ($auditTrail->isNewRecord) {
//    $this->menu[] = array(
//        'label' => Yii::t('dressing', 'Create'),
//        'url' => array('/auditTrail/create'),
//    );
//    return; // no more links
//}

// view
$this->menu[] = array(
    'label' => Yii::t('dressing', 'View'),
    'url' => $auditTrail->getUrl(),
);

// others
foreach ($auditTrail->getMenuLinks(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

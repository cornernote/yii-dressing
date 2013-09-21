<?php
/**
 * @var $this AuditController
 * @var $audit YdAudit
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdMenu::getItemsFromMenu('Logs', YdMenu::MENU_ADMIN);
    return; // no more links
}

// create
//if ($audit->isNewRecord) {
//    $this->menu[] = array(
//        'label' => Yii::t('dressing', 'Create'),
//        'url' => array('/audit/create'),
//    );
//    return; // no more links
//}

// view
$this->menu[] = array(
    'label' => Yii::t('dressing', 'View'),
    'url' => $audit->getUrl(),
);

// others
foreach ($audit->getMenuLinks(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

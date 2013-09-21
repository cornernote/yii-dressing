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
//        'label' => Yii::t('dressing', 'Create'),
//        'url' => array('/emailSpool/create'),
//    );
//    return; // no more links
//}

// view
$this->menu[] = array(
    'label' => Yii::t('dressing', 'View'),
    'url' => $emailSpool->getUrl(),
);

// others
foreach ($emailSpool->getMenuLinks(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

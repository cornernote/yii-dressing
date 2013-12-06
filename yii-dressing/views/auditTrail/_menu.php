<?php
/**
 * @var $this YdAuditTrailController
 * @var $auditTrail YdAuditTrail
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdSiteMenu::getItemsFromMenu('Logs', YdSiteMenu::MENU_ADMIN);
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

<?php
/**
 * @var $this AuditTrailController
 * @var $auditTrail YdAuditTrail
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
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

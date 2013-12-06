<?php
/**
 * @var $this AuditController
 * @var $audit YdAudit
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

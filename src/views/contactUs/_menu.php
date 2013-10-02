<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdMenu::getItemsFromMenu('Log', YdMenu::MENU_ADMIN);
    return; // no more links
}

// create
if ($contactUs->isNewRecord) {
    $this->menu[] = array(
        'label' => Yii::t('dressing', 'Create'),
        'url' => array('/contactUs/create'),
    );
    return; // no more links
}

// view
$this->menu[] = array(
    'label' => Yii::t('dressing', 'View'),
    'url' => $contactUs->getUrl(),
);

// others
foreach ($contactUs->getMenuLinks(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

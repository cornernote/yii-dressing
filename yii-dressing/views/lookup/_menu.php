<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdSiteMenu::getItemsFromMenu('Settings', YdSiteMenu::MENU_ADMIN);
    return; // no more links
}

// create
if ($lookup->isNewRecord) {
    $this->menu[] = array(
        'label' => Yii::t('dressing', 'Create'),
        'url' => array('/lookup/create'),
    );
    return; // no more links
}

// view
$this->menu[] = array(
    'label' => Yii::t('dressing', 'View'),
    'url' => $lookup->getUrl(),
);

// others
foreach ($lookup->getMenuLinks(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

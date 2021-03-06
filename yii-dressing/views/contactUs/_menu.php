<?php
/**
 * @var $this YdContactUsController
 * @var $contactUs YdContactUs
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

// index
if (!isset($contactUs)) {
    $this->menu = SiteMenu::getItemsFromMenu(SiteMenu::MENU_MAIN);
    return; // no more links
}

$menu = array();

// create
if ($contactUs->isNewRecord) {
    //$menu[] = array(
    //    'label' => Yii::t('app', 'Create'),
    //    'url' => array('/contactUs/create'),
    //);
    return; // no more links
}

// view
$menu[] = array(
    'label' => Yii::t('app', 'View'),
    'url' => $contactUs->getUrl(),
);

// others
foreach ($contactUs->getMenuLinks(true) as $linkItem) {
    $menu[] = $linkItem;
}

if (empty($render) || Yii::app()->getRequest()->getIsAjaxRequest())
    $this->menu = $menu;
else
    $this->widget('bootstrap.widgets.TbNav', array(
        'type' => TbHtml::NAV_TYPE_TABS,
        'items' => $menu,
    ));
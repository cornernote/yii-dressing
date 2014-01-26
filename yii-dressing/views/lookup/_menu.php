<?php
/**
 * @var $this YdLookupController
 * @var $lookup YdLookup
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

// index
if (!isset($lookup)) {
    $this->menu = SiteMenu::getItemsFromMenu(SiteMenu::MENU_ADMIN);
    return; // no more links
}

$menu = array();

// create
if ($lookup->isNewRecord) {
    //$menu[] = array(
    //    'label' => Yii::t('app', 'Create'),
    //    'url' => array('/lookup/create'),
    //);
    return; // no more links
}

// view
$menu[] = array(
    'label' => Yii::t('app', 'View'),
    'url' => $lookup->getUrl(),
);

// others
foreach ($lookup->getMenuLinks(true) as $linkItem) {
    $menu[] = $linkItem;
}

if (empty($render) || Yii::app()->getRequest()->getIsAjaxRequest())
    $this->menu = $menu;
else
    $this->widget('bootstrap.widgets.TbNav', array(
        'type' => TbHtml::NAV_TYPE_TABS,
        'items' => $menu,
    ));
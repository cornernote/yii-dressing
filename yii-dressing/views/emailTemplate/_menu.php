<?php
/**
 * @var $this YdEmailTemplateController
 * @var $emailTemplate YdEmailTemplate
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

// index
if (!isset($emailTemplate)) {
    $this->menu = YdSiteMenu::getItemsFromMenu('Settings', YdSiteMenu::MENU_ADMIN);
    return; // no more links
}

$menu = array();

// create
if ($emailTemplate->isNewRecord) {
    //$menu[] = array(
    //    'label' => Yii::t('app', 'Create'),
    //    'url' => array('/emailTemplate/create'),
    //);
    return; // no more links
}

// view
$menu[] = array(
    'label' => Yii::t('app', 'View'),
    'url' => $emailTemplate->getUrl(),
);

// others
foreach ($emailTemplate->getMenuLinks(true) as $linkItem) {
    $menu[] = $linkItem;
}

if (empty($render) || Yii::app()->getRequest()->getIsAjaxRequest())
    $this->menu = $menu;
else
    $this->widget('bootstrap.widgets.TbMenu', array(
        'type' => 'tabs',
        'items' => $menu,
    ));
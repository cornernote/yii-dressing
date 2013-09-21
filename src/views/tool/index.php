<?php
/**
 * @var $this UserController
 * @var $user YdUser
 */

$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Tools');

$this->breadcrumbs[] = Yii::t('dressing', 'Tools');

$this->menu = YdMenu::getItemsFromMenu('User');

$items = YdMenu::getItemsFromMenu('Admin');
foreach ($items as $item) {
    echo '<h2>' . $item['label'] . '</h2>';
    $this->widget('bootstrap.widgets.TbMenu', array(
        'type' => 'pills',
        'items' => $item['items'],
    ));
}

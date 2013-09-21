<?php
/**
 * @var $this MenuController
 * @var $menus YdMenu[]
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Menus');

$this->renderPartial('dressing.views.menu._menu');

echo '<div class="spacer">';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Create') . ' ' . $this->getName(),
    'url' => array('/menu/create'),
    'type' => 'primary',
    'htmlOptions' => array('data-toggle' => 'modal-remote'),
));
echo '</div>';

$items = array();
foreach ($menus as $menu) {
    $items[] = array('label' => $menu->getName(), 'url' => $menu->getUrl());
}

$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked' => true, // whether this is a stacked menu
    'items' => $items,
));

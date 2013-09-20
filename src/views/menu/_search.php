<?php
/**
 * @var $this MenuController
 * @var $menu Menu
 */

Helper::searchToggle('menu-grid');
echo '<div class="search-form hide">';

/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
	'action' => url($this->route),
	'type' => 'horizontal',
	'method' => 'get',
));

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' .t('Search') . '</legend>';
echo $form->textFieldRow($menu, 'id');
echo $form->textFieldRow($menu, 'parent_id');
echo $form->textFieldRow($menu, 'label');
echo $form->textFieldRow($menu, 'icon');
echo $form->textFieldRow($menu, 'url');
echo $form->textFieldRow($menu, 'url_params');
echo $form->textFieldRow($menu, 'target');
echo $form->textFieldRow($menu, 'access_role');
echo $form->textFieldRow($menu, 'created');
echo $form->textFieldRow($menu, 'deleted');
echo $form->textFieldRow($menu, 'sort_order');
echo $form->textFieldRow($menu, 'enabled');
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => t('Search')));
echo '</div>';

$this->endWidget();
echo '</div>';

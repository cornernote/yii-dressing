<?php
/**
 * @var $this LookupController
 * @var $lookup Lookup
 */

Helper::searchToggle('lookup-grid');
echo '<div class="search-form hide">';

/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
	'action' => url($this->route),
	'type' => 'horizontal',
	'method' => 'get',
));

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' .t('Search') . '</legend>';
echo $form->textFieldRow($lookup, 'id');
echo $form->textFieldRow($lookup, 'name');
echo $form->textFieldRow($lookup, 'type');
echo $form->textFieldRow($lookup, 'position');
echo $form->textFieldRow($lookup, 'created');
echo $form->textFieldRow($lookup, 'deleted');
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => t('Search')));
echo '</div>';

$this->endWidget();
echo '</div>';

<?php
/**
 * @var $this NoteController
 * @var $note Note
 */

Helper::searchToggle('note-grid');
echo '<div class="search-form hide">';

/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
	'action' => url($this->route),
	'type' => 'horizontal',
	'method' => 'get',
));

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' .t('Search') . '</legend>';
echo $form->textFieldRow($note, 'id');
echo $form->textFieldRow($note, 'notes');
echo $form->textFieldRow($note, 'model');
echo $form->textFieldRow($note, 'model_id');
echo $form->textFieldRow($note, 'sort_order');
echo $form->textFieldRow($note, 'important');
echo $form->textFieldRow($note, 'created');
echo $form->textFieldRow($note, 'deleted');
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => t('Search')));
echo '</div>';

$this->endWidget();
echo '</div>';

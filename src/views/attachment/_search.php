<?php
/**
 * @var $this AttachmentController
 * @var $attachment Attachment
 */

Helper::searchToggle('attachment-grid');
echo '<div class="search-form hide">';

/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
	'action' => url($this->route),
	'type' => 'horizontal',
	'method' => 'get',
));

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' .t('Search') . '</legend>';
echo $form->textFieldRow($attachment, 'id');
echo $form->textFieldRow($attachment, 'model');
echo $form->textFieldRow($attachment, 'model_id');
echo $form->textFieldRow($attachment, 'filename');
echo $form->textFieldRow($attachment, 'extension');
echo $form->textFieldRow($attachment, 'filetype');
echo $form->textFieldRow($attachment, 'filesize');
echo $form->textFieldRow($attachment, 'notes');
echo $form->textFieldRow($attachment, 'sort_order');
echo $form->textFieldRow($attachment, 'created');
echo $form->textFieldRow($attachment, 'deleted');
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => t('Search')));
echo '</div>';

$this->endWidget();
echo '</div>';

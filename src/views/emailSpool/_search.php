<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool EmailSpool
 */

Helper::searchToggle('emailSpool-grid');
echo '<div class="search-form hide">';

/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
	'action' => url($this->route),
	'type' => 'horizontal',
	'method' => 'get',
));

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' .t('Search') . '</legend>';
echo $form->textFieldRow($emailSpool, 'id');
echo $form->textFieldRow($emailSpool, 'status');
echo $form->textFieldRow($emailSpool, 'model');
echo $form->textFieldRow($emailSpool, 'model_id');
echo $form->textFieldRow($emailSpool, 'to_email');
echo $form->textFieldRow($emailSpool, 'to_name');
echo $form->textFieldRow($emailSpool, 'from_email');
echo $form->textFieldRow($emailSpool, 'from_name');
echo $form->textFieldRow($emailSpool, 'message_subject');
echo $form->textFieldRow($emailSpool, 'message_html');
echo $form->textFieldRow($emailSpool, 'message_text');
echo $form->textFieldRow($emailSpool, 'sent');
echo $form->textFieldRow($emailSpool, 'created');
echo $form->textFieldRow($emailSpool, 'deleted');
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => t('Search')));
echo '</div>';

$this->endWidget();
echo '</div>';

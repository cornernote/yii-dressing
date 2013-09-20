<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate EmailTemplate
 */

Helper::searchToggle('emailTemplate-grid');
echo '<div class="search-form hide">';

/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
	'action' => url($this->route),
	'type' => 'horizontal',
	'method' => 'get',
));

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' .t('Search') . '</legend>';
echo $form->textFieldRow($emailTemplate, 'id');
echo $form->textFieldRow($emailTemplate, 'name');
echo $form->textFieldRow($emailTemplate, 'message_subject');
echo $form->textFieldRow($emailTemplate, 'message_html');
echo $form->textFieldRow($emailTemplate, 'message_text');
echo $form->textFieldRow($emailTemplate, 'description');
echo $form->textFieldRow($emailTemplate, 'created');
echo $form->textFieldRow($emailTemplate, 'deleted');
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => t('Search')));
echo '</div>';

$this->endWidget();
echo '</div>';

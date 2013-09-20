<?php
/**
 * @var $this ContactUsController
 * @var $contactUs ContactUs
 */

Helper::searchToggle('contactUs-grid');
echo '<div class="search-form hide">';

/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
	'action' => url($this->route),
	'type' => 'horizontal',
	'method' => 'get',
));

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' .t('Search') . '</legend>';
echo $form->textFieldRow($contactUs, 'id');
echo $form->textFieldRow($contactUs, 'name');
echo $form->textFieldRow($contactUs, 'email');
echo $form->textFieldRow($contactUs, 'phone');
echo $form->textFieldRow($contactUs, 'company');
echo $form->textFieldRow($contactUs, 'subject');
echo $form->textFieldRow($contactUs, 'message');
echo $form->textFieldRow($contactUs, 'created_at');
echo $form->textFieldRow($contactUs, 'ip_address');
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => t('Search')));
echo '</div>';

$this->endWidget();
echo '</div>';

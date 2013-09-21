<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool YdEmailSpool
 */

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'type' => 'horizontal',
    'method' => 'get',
    'htmlOptions' => array('class' => 'hide'),
));
$form->searchToggle('emailSpool-grid-search', 'emailSpool-grid');

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' . Yii::t('dressing', 'Search') . '</legend>';
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
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => Yii::t('dressing', 'Search')));
echo '</div>';

$this->endWidget();

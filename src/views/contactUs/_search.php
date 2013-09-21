<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 */

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'type' => 'horizontal',
    'method' => 'get',
    'htmlOptions' => array('class' => 'hide'),
));
$form->searchToggle('contactUs-grid-search', 'contactUs-grid');

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' . Yii::t('dressing', 'Search') . '</legend>';
echo $form->textFieldRow($contactUs, 'id');
echo $form->textFieldRow($contactUs, 'name');
echo $form->textFieldRow($contactUs, 'email');
echo $form->textFieldRow($contactUs, 'phone');
echo $form->textFieldRow($contactUs, 'company');
echo $form->textFieldRow($contactUs, 'subject');
echo $form->textFieldRow($contactUs, 'message');
echo $form->textFieldRow($contactUs, 'ip_address');
echo $form->textFieldRow($contactUs, 'created');
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => Yii::t('dressing', 'Search')));
echo '</div>';

$this->endWidget();

<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate YdEmailTemplate
 */

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    //'action' => Yii::app()->createUrl($this->route),
    'type' => 'horizontal',
    'method' => 'get',
    'htmlOptions' => array('class' => 'hide'),
));
$form->searchToggle('emailTemplate-grid-search', 'emailTemplate-grid');

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' . Yii::t('dressing', 'Search') . '</legend>';
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
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => Yii::t('dressing', 'Search')));
echo '</div>';

$this->endWidget();

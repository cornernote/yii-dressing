<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate EmailTemplate
 */

/* @var $form ActiveForm */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'emailTemplate-form',
    'enableAjaxValidation' => true,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'class' => app()->request->isAjaxRequest ? 'modal-form' : '',
    ),
));
echo $form->beginModalWrap();
echo $form->errorSummary($emailTemplate);
echo $form->textAreaRow($emailTemplate, 'description');
echo $form->textFieldRow($emailTemplate, 'message_subject');
echo $form->textAreaRow($emailTemplate, 'message_html');
echo $form->textAreaRow($emailTemplate, 'message_text');

echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'icon' => 'ok white',
    'label' => $emailTemplate->isNewRecord ? t('Create') : t('Save'),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();
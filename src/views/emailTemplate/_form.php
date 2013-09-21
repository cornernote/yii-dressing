<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate YdEmailTemplate
 */

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
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
    'label' => $emailTemplate->isNewRecord ? Yii::t('dressing', 'Create') : Yii::t('dressing', 'Save'),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();
<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool EmailSpool
 */

/* @var $form ActiveForm */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'emailSpool-form',
    'enableAjaxValidation' => true,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'class' => app()->request->isAjaxRequest ? 'modal-form' : '',
    ),
));
echo $form->beginModalWrap();
echo $form->errorSummary($emailSpool);
echo $form->textAreaRow($emailSpool, 'description');
echo $form->textFieldRow($emailSpool, 'message_subject');
echo $form->textAreaRow($emailSpool, 'message_html');
echo $form->textAreaRow($emailSpool, 'message_text');

echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'icon' => 'ok white',
    'label' => $emailSpool->isNewRecord ? t('Create') : t('Save'),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();
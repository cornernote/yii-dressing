<?php
/**
 * @var $this NoteController
 * @var $note Note
 */

/** @var $form ActiveForm */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'note-form',
    'type' => 'horizontal',
    //'enableAjaxValidation' => true,
));
echo $form->beginModalWrap();
echo $form->errorSummary($note);

echo $form->textFieldRow($note, 'notes');
echo $form->textFieldRow($note, 'model');
echo $form->textFieldRow($note, 'model_id');
echo $form->textFieldRow($note, 'sort_order');
echo $form->textFieldRow($note, 'important');
echo $form->textFieldRow($note, 'created');
echo $form->textFieldRow($note, 'deleted');

echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'icon' => 'ok white',
    'label' => $note->isNewRecord ? t('Create') : t('Save'),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();

<?php
/**
 * @var $this LookupController
 * @var $lookup Lookup
 */

/** @var $form ActiveForm */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'lookup-form',
    'type' => 'horizontal',
    //'enableAjaxValidation' => true,
));
echo $form->beginModalWrap();
echo $form->errorSummary($lookup);

echo $form->textFieldRow($lookup, 'name');
echo $form->textFieldRow($lookup, 'type');
echo $form->textFieldRow($lookup, 'position');
echo $form->textFieldRow($lookup, 'created');
echo $form->textFieldRow($lookup, 'deleted');

echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'icon' => 'ok white',
    'label' => $lookup->isNewRecord ? t('Create') : t('Save'),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();

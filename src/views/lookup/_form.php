<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 */

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
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
    'label' => $lookup->isNewRecord ? Yii::t('dressing', 'Create') : Yii::t('dressing', 'Save'),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();

<?php
/**
 * @var $this AuditTrailController
 * @var $auditTrail YdAuditTrail
 */

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    //'action' => Yii::app()->createUrl($this->route),
    'type' => 'horizontal',
    'method' => 'get',
    'htmlOptions' => array('class' => 'hide'),
));
$form->searchToggle('auditTrail-grid-search', 'auditTrail-grid');

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' . Yii::t('dressing', 'Search') . '</legend>';
echo $form->textFieldRow($auditTrail, 'id');
echo $form->textFieldRow($auditTrail, 'audit_id');
echo $form->textFieldRow($auditTrail, 'old_value');
echo $form->textFieldRow($auditTrail, 'new_value');
echo $form->textFieldRow($auditTrail, 'action');
echo $form->textFieldRow($auditTrail, 'model');
echo $form->textFieldRow($auditTrail, 'model_id');
echo $form->textFieldRow($auditTrail, 'field');
echo $form->textFieldRow($auditTrail, 'created');
echo $form->textFieldRow($auditTrail, 'user_id');
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => Yii::t('dressing', 'Search')));
echo '</div>';

$this->endWidget();

<?php
/**
 * @var $this AuditTrailController
 * @var $auditTrail AuditTrail
 */

Helper::searchToggle('auditTrail-grid');
echo '<div class="search-form hide">';

/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'action' => url($this->route),
    'type' => 'horizontal',
    'method' => 'get',
));

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' . t('Search') . '</legend>';
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
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => t('Search')));
echo '</div>';

$this->endWidget();
echo '</div>';

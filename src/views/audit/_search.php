<?php
/**
 * @var $this AuditController
 * @var $audit YdAudit
 */


/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    //'action' => Yii::app()->createUrl($this->route),
    'type' => 'horizontal',
    'method' => 'get',
    'htmlOptions' => array('class' => 'hide'),
));
$form->searchToggle('audit-grid-search', 'audit-grid');

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' . Yii::t('dressing', 'Search') . '</legend>';
echo $form->textFieldRow($audit, 'name');
echo $form->textFieldRow($audit, 'email', array('size' => 60, 'maxlength' => 255));
echo $form->dropDownListRow($audit, 'role', CHtml::listData(YdRole::model()->findAll(), 'id', 'name'), array('empty' => ''));
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => Yii::t('dressing', 'Search')));
echo '</div>';

$this->endWidget();

<?php
/**
 * @var $this UserController
 * @var $user YdUser
 */


/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'action' => url($this->route),
    'type' => 'horizontal',
    'method' => 'get',
    'htmlOptions' => array('class' => 'hide'),
));
$form->searchToggle('user-grid-search', 'user-grid');

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' . t('Search') . '</legend>';
echo $form->textFieldRow($user, 'name');
echo $form->textFieldRow($user, 'email', array('size' => 60, 'maxlength' => 255));
echo $form->dropDownListRow($user, 'role', CHtml::listData(YdRole::model()->findAll(), 'id', 'name'), array('empty' => ''));
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => t('Search')));
echo '</div>';

$this->endWidget();

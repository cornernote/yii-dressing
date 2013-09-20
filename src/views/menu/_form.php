<?php
/**
 * @var $this MenuController
 * @var $menu Menu
 */

/** @var $form ActiveForm */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'menu-form',
    'type' => 'horizontal',
    //'enableAjaxValidation' => true,
));
echo $form->beginModalWrap();
echo $form->errorSummary($menu);

echo $form->textFieldRow($menu, 'parent_id');
echo $form->textFieldRow($menu, 'label');
echo $form->textFieldRow($menu, 'icon');
echo $form->textFieldRow($menu, 'url');
echo $form->textFieldRow($menu, 'url_params');
echo $form->textFieldRow($menu, 'target');
echo $form->textFieldRow($menu, 'access_role');
echo $form->textFieldRow($menu, 'created');
echo $form->textFieldRow($menu, 'deleted');
echo $form->textFieldRow($menu, 'sort_order');
echo $form->textFieldRow($menu, 'enabled');

echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'icon' => 'ok white',
    'label' => $menu->isNewRecord ? t('Create') : t('Save'),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();

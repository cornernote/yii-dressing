<?php
/**
 * @var $this AccountController
 * @var $user User
 */
$this->pageTitle = $this->pageHeading = t('Update Account');
$this->breadcrumbs = array(
    t('My Account') => array('index'),
    t('Update Account'),
);
$this->menu = Menu::getItemsFromMenu('User');

/* @var $form ActiveForm */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'account-form',
    //'enableAjaxValidation' => true,
    'type' => 'horizontal',
));
echo $form->beginModalWrap();
echo $form->errorSummary($user);

echo $form->textFieldRow($user, 'username');
echo $form->textFieldRow($user, 'name');
echo $form->textFieldRow($user, 'email');
echo $form->textFieldRow($user, 'phone');

echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'icon' => 'ok white',
    'label' => t('Save'),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();

<?php
/**
 * @var $this AccountController
 * @var $form ActiveForm
 * @var $user User
 */
$this->pageTitle = $this->pageHeading = t('Set Password');
$this->breadcrumbs = array(
    t('Set Password'),
);

/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'password-form',
    //'enableAjaxValidation' => true,
    'type' => 'horizontal',
));

echo $form->beginModalWrap();
echo $form->errorSummary($user);

echo $form->passwordFieldRow($user, 'password');
echo $form->passwordFieldRow($user, 'confirm_password');

echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'icon' => 'ok white',
    'label' => t('Save'),
));
echo '</div>';
$this->endWidget();
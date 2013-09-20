<?php
/**
 * @var $this AccountController
 * @var $user UserRegister
 */
$this->pageTitle = $this->pageHeading = t('Sign Up');
$this->breadcrumbs = array(
    t('Sign Up'),
);

/* @var $form ActiveForm */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'register-form',
    //'enableAjaxValidation' => true,
    'type' => 'horizontal',
));
echo $form->beginModalWrap();
echo $form->errorSummary($user);
echo $form->textFieldRow($user, 'email');
echo $form->passwordFieldRow($user, 'password');
echo $form->endModalWrap();

echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => t('Register'),
    'type' => 'primary',
    'buttonType' => 'submit',
));
echo ' ';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => t('Already have an account?'),
    'url' => array('/account/login'),
));
echo '</div>';
$this->endWidget();

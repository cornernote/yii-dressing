<?php
/**
 * @var $this AccountController
 * @var $user YdUserRegister
 */
$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Sign Up');

$this->breadcrumbs[] = Yii::t('dressing', 'Sign Up');

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
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
    'label' => Yii::t('dressing', 'Sign Up'),
    'type' => 'primary',
    'buttonType' => 'submit',
));
echo ' ';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Already have an account?'),
    'url' => array('/account/login'),
));
echo '</div>';
$this->endWidget();

<?php
/**
 * @var $this AccountController
 * @var $user YdUserLogin
 * @var $recaptcha string
 */

$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Login');

$this->breadcrumbs[] = Yii::t('dressing', 'Login');

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'login-form',
    //'enableAjaxValidation' => false,
    'type' => 'horizontal',
));
echo $form->beginModalWrap();
echo $form->errorSummary($user);
echo $form->textFieldRow($user, 'email');
echo $form->passwordFieldRow($user, 'password');
echo $form->checkBoxRow($user, 'remember_me');

if ($recaptcha) {
    echo CHtml::activeLabel($user, 'recaptcha');
    $this->widget('widgets.ReCaptcha', array(
        'model' => $user, 'attribute' => 'recaptcha',
        'theme' => 'red', 'language' => 'en_EN',
        'publicKey' => YdSetting::item('recaptchaPublic'),
    ));
    echo CHtml::error($user, 'recaptcha');
}
echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Login'),
    'type' => 'primary',
    'buttonType' => 'submit',
));
echo ' ';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Lost Password'),
    'url' => array('/account/recover'),
));
echo ' ';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Register New Account'),
    'url' => array('/account/register'),
));
echo '</div>';
$this->endWidget();
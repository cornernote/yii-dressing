<?php
/**
 * @var $this AccountController
 * @var $user UserRecover
 * @var $recaptcha string
 */

$this->pageTitle = $this->pageHeading = t('Recover Password');
$this->breadcrumbs = array(
    t('Recover Password'),
);

/* @var $form ActiveForm */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'recover-form',
    //'enableAjaxValidation' => false,
    'type' => 'horizontal',
));
echo $form->beginModalWrap();
echo $form->errorSummary($user);

echo $form->textFieldRow($user, 'username_or_email');
if ($recaptcha) {
    echo CHtml::activeLabel($user, 'recaptcha');
    $this->widget('widgets.ReCaptcha', array(
        'model' => $user,
        'attribute' => 'recaptcha',
        'theme' => 'red',
        'language' => 'en_EN',
        'publicKey' => Setting::item('recaptchaPublic'),
    ));
    echo CHtml::error($user, 'recaptcha');
}
echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => t('Recover'),
    'type' => 'primary',
    'buttonType' => 'submit',
));
echo ' ';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => t('Back to Login'),
    'url' => array('/account/login'),
));
echo '</div>';
$this->endWidget();

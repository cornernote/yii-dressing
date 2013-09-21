<?php
/**
 * @var $this AccountController
 * @var $user YdUserRecover
 * @var $recaptcha string
 */

$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Recover Password');
$this->breadcrumbs[] = Yii::t('dressing', 'Recover Password');


/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
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
        'publicKey' => YdSetting::item('recaptchaPublic'),
    ));
    echo CHtml::error($user, 'recaptcha');
}
echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Recover'),
    'type' => 'primary',
    'buttonType' => 'submit',
));
echo ' ';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Back to Login'),
    'url' => array('/account/login'),
));
echo '</div>';
$this->endWidget();

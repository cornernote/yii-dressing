<?php
/**
 * @var $this AccountController
 * @var $user YdUserRegister
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
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
echo $form->textFieldRow($user, 'first_name');
echo $form->textFieldRow($user, 'last_name');

echo $form->textFieldRow($user, 'username');
echo $form->passwordFieldRow($user, 'password');
echo $form->passwordFieldRow($user, 'confirm_password');

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

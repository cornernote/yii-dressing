<?php
/**
 * @var $this YdAccountController
 * @var $accountSignup YdUserRegister
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
$this->pageTitle = Yii::t('dressing', 'Sign Up');

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'register-form',
));
echo $form->beginModalWrap();
echo $form->errorSummary($accountSignup);

echo $form->textFieldControlGroup($accountSignup, 'email');
echo $form->textFieldControlGroup($accountSignup, 'first_name');
echo $form->textFieldControlGroup($accountSignup, 'last_name');

echo $form->textFieldControlGroup($accountSignup, 'username');
echo $form->passwordFieldControlGroup($accountSignup, 'password');
echo $form->passwordFieldControlGroup($accountSignup, 'confirm_password');

echo $form->endModalWrap();
echo $form->getSubmitButtonRow(Yii::t('dressing', 'Signup'));
$this->endWidget();

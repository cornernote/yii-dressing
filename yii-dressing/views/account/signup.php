<?php
/**
 * @var $this YdAccountController
 * @var $user YdUserRegister
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
echo $form->errorSummary($user);

echo $form->textFieldControlGroup($user, 'email');
echo $form->textFieldControlGroup($user, 'first_name');
echo $form->textFieldControlGroup($user, 'last_name');

echo $form->textFieldControlGroup($user, 'username');
echo $form->passwordFieldControlGroup($user, 'password');
echo $form->passwordFieldControlGroup($user, 'confirm_password');

echo $form->endModalWrap();
echo $form->getSubmitButtonRow(Yii::t('dressing', 'Signup'));
$this->endWidget();

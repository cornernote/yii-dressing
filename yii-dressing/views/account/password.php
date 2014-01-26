<?php
/**
 * @var $this YdAccountController
 * @var $user YdUser
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
$this->pageTitle = Yii::t('dressing', 'Change Password');

$this->menu = SiteMenu::getItemsFromMenu(SiteMenu::MENU_USER);

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'password-form',
));
echo $form->beginModalWrap();
echo $form->errorSummary($user);

echo $form->passwordFieldControlGroup($user, 'current_password');
echo $form->passwordFieldControlGroup($user, 'new_password');
echo $form->passwordFieldControlGroup($user, 'confirm_password');

echo $form->endModalWrap();
echo $form->getSubmitButtonRow(Yii::t('dressing', 'Save'));
$this->endWidget();
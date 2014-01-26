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
$this->pageTitle = Yii::t('dressing', 'Update Account');

$this->menu = SiteMenu::getItemsFromMenu(SiteMenu::MENU_USER);

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'account-form',
));
echo $form->beginModalWrap();
echo $form->errorSummary($user);

echo $form->textFieldControlGroup($user, 'username');
echo $form->textFieldControlGroup($user, 'name');
echo $form->textFieldControlGroup($user, 'email');
echo $form->textFieldControlGroup($user, 'phone');

echo $form->endModalWrap();
echo $form->getSubmitButtonRow(Yii::t('dressing', 'Save'));
$this->endWidget();

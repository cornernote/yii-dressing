<?php
/**
 * @var $this AccountController
 * @var $user YdUser
 */
$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Change Password');

$this->breadcrumbs[Yii::t('dressing', 'My Account')] = array('/account/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Change Password');

$this->menu = YdMenu::getItemsFromMenu('User');

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'password-form',
    //'enableAjaxValidation' => true,
    'type' => 'horizontal',
));
echo $form->beginModalWrap();
echo $form->errorSummary($user);

echo $form->passwordFieldRow($user, 'current_password');
echo $form->passwordFieldRow($user, 'password');
echo $form->passwordFieldRow($user, 'confirm_password');

echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'icon' => 'ok white',
    'label' => Yii::t('dressing', 'Save'),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();
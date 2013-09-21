<?php
/**
 * @var $this AccountController
 * @var $user YdUser
 */
$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Update Account');

$this->breadcrumbs[Yii::t('dressing', 'My Account')] = array('/account/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Update Account');

$this->menu = YdMenu::getItemsFromMenu('User');

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'account-form',
    //'enableAjaxValidation' => true,
    'type' => 'horizontal',
));
echo $form->beginModalWrap();
echo $form->errorSummary($user);

echo $form->textFieldRow($user, 'username');
echo $form->textFieldRow($user, 'name');
echo $form->textFieldRow($user, 'email');
echo $form->textFieldRow($user, 'phone');

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

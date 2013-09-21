<?php
/**
 * @var $this AccountController
 * @var $form YdActiveForm
 * @var $user YdUser
 */
$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Account Settings');

$this->breadcrumbs[Yii::t('dressing', 'My Account')] = array('/account/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Account Settings');

$this->menu = YdMenu::getItemsFromMenu('User');

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'account-form',
    //'enableAjaxValidation' => true,
    'type' => 'horizontal',
));
echo $form->beginModalWrap();
echo $form->errorSummary($user);

?>
    <div class="control-group">
        <?php echo CHtml::label(Yii::t('dressing', 'Theme'), 'UserEav_theme', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo CHtml::dropDownList('UserEav[theme]', $user->getEavAttribute('theme'), YdSetting::themes());
            ?>
        </div>
    </div>
<?php

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

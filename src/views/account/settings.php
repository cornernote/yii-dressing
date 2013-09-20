<?php
/**
 * @var $this AccountController
 * @var $form ActiveForm
 * @var $user User
 */
$this->pageTitle = $this->pageHeading = t('Account Settings');
$this->breadcrumbs = array(
    t('My Account') => array('index'),
    t('Account Settings'),
);
$this->menu = Menu::getItemsFromMenu('User');

/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'account-form',
    //'enableAjaxValidation' => true,
    'type' => 'horizontal',
));
echo $form->beginModalWrap();
echo $form->errorSummary($user);

?>
    <div class="control-group">
        <?php echo CHtml::label(t('Theme'), 'UserEav_theme', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo CHtml::dropDownList('UserEav[theme]', $user->getEavAttribute('theme'), param('themes'));
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
    'label' => t('Save'),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();

<?php
/**
 * @var $this YdAccountController
 * @var $form YdActiveForm
 * @var $user YdUser
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
$this->pageTitle = Yii::t('dressing', 'Account Settings');

$this->menu = YdSiteMenu::getItemsFromMenu('User');

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'account-form',
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

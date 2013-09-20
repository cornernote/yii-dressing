<?php
/**
 * @var $this UserController
 * @var $user User
 */

Helper::searchToggle('user-grid');
?>
<div class="search-form hide">
    <?php
    /** @var ActiveForm $form */
    $form = $this->beginWidget('widgets.ActiveForm', array(
        'action' => url($this->route),
        'type' => 'horizontal',
        'method' => 'get',
    ));
    ?>
    <fieldset>
        <legend><?php echo t('User Search'); ?></legend>
        <?php
        echo $form->textFieldRow($user, 'name');
        echo $form->textFieldRow($user, 'email', array('size' => 60, 'maxlength' => 255));
        echo $form->dropDownListRow($user, 'role', CHtml::listData(Role::model()->findAll(), 'id', 'name'), array('empty' => ''));
        ?>
    </fieldset>
    <div class="form-actions">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => t('Search')));
        ?>
    </div>
    <?php
    $this->endWidget();
    ?>
</div>
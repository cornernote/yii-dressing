<?php
/**
 * @var $this YdSiteMenuController
 * @var $menu YdSiteMenu
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'menu-form',
    'type' => 'horizontal',
    //'enableAjaxValidation' => true,
));
echo $form->beginModalWrap();
echo $form->errorSummary($menu);

echo $form->dropDownListRow($menu, 'parent_id', YdSiteMenu::model()->getDropDown(), array('empty' => ''));
echo $form->textFieldRow($menu, 'label');
echo $form->textFieldRow($menu, 'icon');
echo $form->textFieldRow($menu, 'url');
echo $form->textFieldRow($menu, 'url_params');
echo $form->textFieldRow($menu, 'target');
echo $form->textFieldRow($menu, 'access_role');
echo $form->checkBoxRow($menu, 'enabled');

echo $form->endModalWrap();
echo $form->getSubmitButtonRow($menu->isNewRecord ? Yii::t('dressing', 'Create') : Yii::t('dressing', 'Save'));
$this->endWidget();

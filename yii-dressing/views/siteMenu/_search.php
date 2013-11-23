<?php
/**
 * @var $this YdSiteMenuController
 * @var $menu YdSiteMenu
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    //'action' => Yii::app()->createUrl($this->route),
    'type' => 'horizontal',
    'method' => 'get',
    'htmlOptions' => array('class' => 'hide'),
));
$form->searchToggle('menu-grid-search', 'menu-grid');

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' . Yii::t('dressing', 'Search') . '</legend>';
echo $form->textFieldRow($menu, 'id');
echo $form->textFieldRow($menu, 'parent_id');
echo $form->textFieldRow($menu, 'label');
echo $form->textFieldRow($menu, 'icon');
echo $form->textFieldRow($menu, 'url');
echo $form->textFieldRow($menu, 'url_params');
echo $form->textFieldRow($menu, 'target');
echo $form->textFieldRow($menu, 'access_role');
echo $form->textFieldRow($menu, 'created');
echo $form->textFieldRow($menu, 'deleted');
echo $form->textFieldRow($menu, 'sort_order');
echo $form->textFieldRow($menu, 'enabled');
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => Yii::t('dressing', 'Search')));
echo '</div>';

$this->endWidget();

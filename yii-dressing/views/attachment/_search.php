<?php
/**
 * @var $this YdAttachmentController
 * @var $attachment YdAttachment
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    //'action' => Yii::app()->createUrl($this->route),
    'type' => 'horizontal',
    'method' => 'get',
    'htmlOptions' => array('class' => 'hide'),
));
$form->searchField('attachment-grid-search', 'attachment-grid');

echo '<fieldset>';
echo '<legend>' . $this->getName() . ' ' . Yii::t('dressing', 'Search') . '</legend>';
echo $form->textFieldControlGroup($attachment, 'id');
echo $form->textFieldControlGroup($attachment, 'model');
echo $form->textFieldControlGroup($attachment, 'model_id');
echo $form->textFieldControlGroup($attachment, 'filename');
echo $form->textFieldControlGroup($attachment, 'extension');
echo $form->textFieldControlGroup($attachment, 'filetype');
echo $form->textFieldControlGroup($attachment, 'filesize');
echo $form->textFieldControlGroup($attachment, 'notes');
echo $form->textFieldControlGroup($attachment, 'sort_order');
echo $form->textFieldControlGroup($attachment, 'created');
echo $form->textFieldControlGroup($attachment, 'deleted');
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => Yii::t('dressing', 'Search')));
echo '</div>';

$this->endWidget();

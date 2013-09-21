<?php
/**
 * @var $this AttachmentController
 * @var $attachment YdAttachment
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
echo $form->textFieldRow($attachment, 'id');
echo $form->textFieldRow($attachment, 'model');
echo $form->textFieldRow($attachment, 'model_id');
echo $form->textFieldRow($attachment, 'filename');
echo $form->textFieldRow($attachment, 'extension');
echo $form->textFieldRow($attachment, 'filetype');
echo $form->textFieldRow($attachment, 'filesize');
echo $form->textFieldRow($attachment, 'notes');
echo $form->textFieldRow($attachment, 'sort_order');
echo $form->textFieldRow($attachment, 'created');
echo $form->textFieldRow($attachment, 'deleted');
echo '</fieldset>';

echo '<div class="form-actions">';
$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => Yii::t('dressing', 'Search')));
echo '</div>';

$this->endWidget();

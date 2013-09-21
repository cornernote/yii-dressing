<?php
/**
 * @var $this AttachmentController
 * @var $id int
 * @var $task string
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', ucfirst($task));

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Attachments')] = Yii::app()->user->getState('index.attachment', array('/attachment/index'));
$this->breadcrumbs[] = Yii::t('dressing', ucfirst($task));

$attachment = $id ? Attachment::model()->findByPk($id) : new Attachment('search');
/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'attachment-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/attachment/delete', 'id' => $id, 'task' => $task, 'confirm', 1),
));
echo $this->getGridIdHiddenFields($id);
echo $form->beginModalWrap();
echo $form->errorSummary($attachment);

echo '<fieldset>';
echo '<legend>' . Yii::t('dressing', 'Selected Records') . '</legend>';
$attachments = Attachment::model()->findAll('t.id IN (' . implode(',', $this->getGridIds($id)) . ')');
if ($attachments) {
	echo '<ul>';
	foreach ($attachments as $attachment) {
		echo '<li>';
		echo $attachment->getName();
		echo '</li>';
	}
	echo '</ul>';
}
echo '</fieldset>';

echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => Yii::t('dressing', 'Confirm ' . ucfirst($task)),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();

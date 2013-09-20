<?php
/**
 * @var $this AttachmentController
 * @var $id int
 * @var $task string
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t(ucfirst($task));
$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.attachment', array('/attachment/index'));
$this->breadcrumbs[] = t(ucfirst($task));

$attachment = $id ? Attachment::model()->findByPk($id) : new Attachment('search');
/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'attachment-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/attachment/delete', 'id' => $id, 'task' => $task, 'confirm', 1),
));
echo sfGridHidden($id);
echo $form->beginModalWrap();
echo $form->errorSummary($attachment);

echo '<fieldset>';
echo '<legend>' . t('Selected Records') . '</legend>';
$attachments = Attachment::model()->findAll('t.id IN (' . implode(',', sfGrid($id)) . ')');
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
    'label' => t('Confirm ' . ucfirst($task)),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();

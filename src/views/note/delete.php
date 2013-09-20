<?php
/**
 * @var $this NoteController
 * @var $id int
 * @var $task string
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t(ucfirst($task));
$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.note', array('/note/index'));
$this->breadcrumbs[] = t(ucfirst($task));

$note = $id ? Note::model()->findByPk($id) : new Note('search');
/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'note-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/note/delete', 'id' => $id, 'task' => $task, 'confirm', 1),
));
echo sfGridHidden($id);
echo $form->beginModalWrap();
echo $form->errorSummary($note);

echo '<fieldset>';
echo '<legend>' . t('Selected Records') . '</legend>';
$notes = Note::model()->findAll('t.id IN (' . implode(',', sfGrid($id)) . ')');
if ($notes) {
	echo '<ul>';
	foreach ($notes as $note) {
		echo '<li>';
		echo $note->getName();
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

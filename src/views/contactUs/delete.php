<?php
/**
 * @var $this ContactUsController
 * @var $id int
 * @var $task string
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t(ucfirst($task));
$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.contactUs', array('/contactUs/index'));
$this->breadcrumbs[] = t(ucfirst($task));

$contactUs = $id ? ContactUs::model()->findByPk($id) : new ContactUs('search');
/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'contactUs-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/contactUs/delete', 'id' => $id, 'task' => $task, 'confirm' => 1),
));
echo sfGridHidden($id);
echo $form->beginModalWrap();
echo $form->errorSummary($contactUs);

echo '<fieldset>';
echo '<legend>' . t('Selected Records') . '</legend>';
$contactUss = ContactUs::model()->findAll('t.id IN (' . implode(',', sfGrid($id)) . ')');
if ($contactUss) {
	echo '<ul>';
	foreach ($contactUss as $contactUs) {
		echo '<li>';
		echo $contactUs->getName();
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

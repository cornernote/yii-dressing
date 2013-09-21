<?php
/**
 * @var $this ContactUsController
 * @var $id int
 * @var $task string
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', ucfirst($task));

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[$this->getName() . ' ' . Yii::t('dressing', 'List')] = Yii::app()->user->getState('index.contactUs', array('/contactUs/index'));
$this->breadcrumbs[] = Yii::t('dressing', ucfirst($task));

$contactUs = $id ? ContactUs::model()->findByPk($id) : new ContactUs('search');

/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'contactUs-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/contactUs/delete', 'id' => $id, 'task' => $task, 'confirm' => 1),
));
echo $this->getGridIdHiddenFields($id);
echo $form->beginModalWrap();
echo $form->errorSummary($contactUs);

echo '<fieldset>';
echo '<legend>' . Yii::t('dressing', 'Selected Records') . '</legend>';
$contactUss = ContactUs::model()->findAll('t.id IN (' . implode(',', $this->getGridIds($id)) . ')');
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
    'label' => Yii::t('dressing', 'Confirm ' . ucfirst($task)),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();

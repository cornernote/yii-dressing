<?php
/**
 * @var $this RoleController
 * @var $id int
 * @var $task string
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', ucfirst($task));

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Roles')] = Yii::app()->user->getState('index.role', array('/role/index'));
$this->breadcrumbs[] = Yii::t('dressing', ucfirst($task));

$role = $id ? Role::model()->findByPk($id) : new Role('search');
/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'role-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/role/delete', 'id' => $id, 'task' => $task, 'confirm' => 1),
));
echo $this->getGridIdHiddenFields($id);
echo $form->beginModalWrap();
echo $form->errorSummary($role);

echo '<fieldset>';
echo '<legend>' . Yii::t('dressing', 'Selected Records') . '</legend>';
$roles = Role::model()->findAll('t.id IN (' . implode(',', $this->getGridIds($id)) . ')');
if ($roles) {
	echo '<ul>';
	foreach ($roles as $role) {
		echo '<li>';
		echo $role->getName();
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

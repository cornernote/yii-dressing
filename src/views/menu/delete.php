<?php
/**
 * @var $this MenuController
 * @var $id int
 * @var $task string
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', ucfirst($task));

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Menus')] = Yii::app()->user->getState('index.menu', array('/menu/index'));
$this->breadcrumbs[] = Yii::t('dressing', ucfirst($task));

$menu = $id ? YdMenu::model()->findByPk($id) : new YdMenu('search');
/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'menu-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/menu/delete', 'id' => $id, 'task' => $task, 'confirm' => 1),
));
echo $this->getGridIdHiddenFields($id);
echo $form->beginModalWrap();
echo $form->errorSummary($menu);

echo '<fieldset>';
echo '<legend>' . Yii::t('dressing', 'Selected Records') . '</legend>';
$menus = YdMenu::model()->findAll('t.id IN (' . implode(',', $this->getGridIds($id)) . ')');
if ($menus) {
    echo '<ul>';
    foreach ($menus as $menu) {
        echo '<li>';
        echo $menu->getName();
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

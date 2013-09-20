<?php
/**
 * @var $this MenuController
 * @var $id int
 * @var $task string
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t(ucfirst($task));
$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.menu', array('/menu/index'));
$this->breadcrumbs[] = t(ucfirst($task));

$menu = $id ? Menu::model()->findByPk($id) : new Menu('search');
/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'menu-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/menu/delete', 'id' => $id, 'task' => $task, 'confirm' => 1),
));
echo sfGridHidden($id);
echo $form->beginModalWrap();
echo $form->errorSummary($menu);

echo '<fieldset>';
echo '<legend>' . t('Selected Records') . '</legend>';
$menus = Menu::model()->findAll('t.id IN (' . implode(',', sfGrid($id)) . ')');
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
    'label' => t('Confirm ' . ucfirst($task)),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();

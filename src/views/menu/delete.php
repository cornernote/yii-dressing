<?php
/**
 * @var $this MenuController
 * @var $id int
 * @var $task string
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t(ucfirst($task));

$this->breadcrumbs[t('Tools')] = array('/tool/index');
$this->breadcrumbs[t('Menus')] = user()->getState('index.menu', array('/menu/index'));
$this->breadcrumbs[] = t(ucfirst($task));

$menu = $id ? YdMenu::model()->findByPk($id) : new YdMenu('search');
/** @var ActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'menu-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/menu/delete', 'id' => $id, 'task' => $task, 'confirm' => 1),
));
echo sfGridHidden($id);
echo $form->beginModalWrap();
echo $form->errorSummary($menu);

echo '<fieldset>';
echo '<legend>' . t('Selected Records') . '</legend>';
$menus = YdMenu::model()->findAll('t.id IN (' . implode(',', sfGrid($id)) . ')');
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

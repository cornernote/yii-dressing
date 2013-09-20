<?php
/**
 * @var $this LookupController
 * @var $id int
 * @var $task string
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t(ucfirst($task));
$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.lookup', array('/lookup/index'));
$this->breadcrumbs[] = t(ucfirst($task));

$lookup = $id ? Lookup::model()->findByPk($id) : new Lookup('search');
/** @var ActiveForm $form */
$form = $this->beginWidget('widgets.ActiveForm', array(
    'id' => 'lookup-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/lookup/delete', 'id' => $id, 'task' => $task, 'confirm' => 1),
));
echo sfGridHidden($id);
echo $form->beginModalWrap();
echo $form->errorSummary($lookup);

echo '<fieldset>';
echo '<legend>' . t('Selected Records') . '</legend>';
$lookups = Lookup::model()->findAll('t.id IN (' . implode(',', sfGrid($id)) . ')');
if ($lookups) {
    echo '<ul>';
    foreach ($lookups as $lookup) {
        echo '<li>';
        echo $lookup->getName();
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

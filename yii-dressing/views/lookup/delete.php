<?php
/**
 * @var $this LookupController
 * @var $id int
 * @var $task string
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

$this->pageTitle = $this->getName() . ' ' . Yii::t('dressing', ucfirst($task));

$lookup = $id ? Lookup::model()->findByPk($id) : new Lookup('search');
/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'lookup-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/lookup/delete', 'id' => $id, 'task' => $task, 'confirm' => 1),
));
echo $this->getGridIdHiddenFields($id);
echo $form->beginModalWrap();
echo $form->errorSummary($lookup);

echo '<fieldset>';
echo '<legend>' . Yii::t('dressing', 'Selected Records') . '</legend>';
$lookups = Lookup::model()->findAll('t.id IN (' . implode(',', YdHelper::getGridIds($id)) . ')');
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
    'label' => Yii::t('dressing', 'Confirm ' . ucfirst($task)),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();

<?php
/**
 * @var $this YdAttachmentController
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

$attachment = $id ? Attachment::model()->findByPk($id) : new Attachment('search');
/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'attachment-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/attachment/delete', 'id' => $id, 'task' => $task, 'confirm', 1),
));
echo $this->getGridIdHiddenFields($id);
echo $form->beginModalWrap();
echo $form->errorSummary($attachment);

echo '<fieldset>';
echo '<legend>' . Yii::t('dressing', 'Selected Records') . '</legend>';
$attachments = Attachment::model()->findAll('t.id IN (' . implode(',', YdHelper::getGridIds($id)) . ')');
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
    'label' => Yii::t('dressing', 'Confirm ' . ucfirst($task)),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();

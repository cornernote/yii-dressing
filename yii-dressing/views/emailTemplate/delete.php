<?php
/**
 * @var $this EmailTemplateController
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

$emailTemplate = $id ? EmailTemplate::model()->findByPk($id) : new EmailTemplate('search');
/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'emailTemplate-' . $task . '-form',
    'type' => 'horizontal',
    'action' => array('/emailTemplate/' . $task, 'id' => $id, 'confirm' => 1),
));
echo $this->getGridIdHiddenFields($id);
echo $form->beginModalWrap();
echo $form->errorSummary($emailTemplate);

echo '<fieldset>';
echo '<legend>' . Yii::t('dressing', 'Selected Records') . '</legend>';
$emailTemplates = EmailTemplate::model()->findAll('t.id IN (' . implode(',', YdHelper::getGridIds($id)) . ')');
if ($emailTemplates) {
    echo '<ul>';
    foreach ($emailTemplates as $emailTemplate) {
        echo '<li>';
        echo $emailTemplate->getName();
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

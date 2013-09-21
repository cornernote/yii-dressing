<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate YdEmailTemplate
 */
$this->pageTitle = $this->pageHeading = $emailTemplate->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'View');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Email Templates')] = Yii::app()->user->getState('index.emailTemplate', array('/emailTemplate/index'));
$this->breadcrumbs[] = $emailTemplate->getName();

$this->renderPartial('dressing.views.emailTemplate._menu', array(
    'emailTemplate' => $emailTemplate,
));

$attributes = array();
$attributes[] = 'name';
$attributes[] = 'description';
$attributes[] = 'message_subject';
$attributes[] = array('name' => 'message_html', 'type' => 'raw');
$attributes[] = 'message_text';
$attributes[] = 'created';

$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $emailTemplate,
    'attributes' => $attributes,
));

<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate EmailTemplate
 */
$this->pageTitle = $this->pageHeading = $emailTemplate->getName() . ' - ' . $this->getName() . ' ' . t('View');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.emailTemplate', array('/emailTemplate/index'));
$this->breadcrumbs[] = $emailTemplate->getName();

$this->renderPartial('_menu', array(
    'emailTemplate' => $emailTemplate,
));

$attributes = array();
$attributes[] = 'name';
$attributes[] = 'description';
$attributes[] = 'message_subject';
$attributes[] = array('name' => 'message_html', 'type' => 'raw');
$attributes[] = 'message_text';
$attributes[] = 'created';
$this->widget('widgets.DetailView', array(
    'data' => $emailTemplate,
    'attributes' => $attributes,
));

<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate EmailTemplate
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('Create');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.emailTemplate', array('/emailTemplate/index'));
$this->breadcrumbs[] = t('Create');

$this->renderPartial('_menu', array(
    'emailTemplate' => $emailTemplate,
));
$this->renderPartial('_form', array(
    'emailTemplate' => $emailTemplate,
));

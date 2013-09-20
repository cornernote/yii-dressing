<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate EmailTemplate
 */
$this->pageTitle = $this->pageHeading = $emailTemplate->getName() . ' - ' . $this->getName() . ' ' . t('Update');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.emailTemplate', array('/emailTemplate/index'));
$this->breadcrumbs[$emailTemplate->getName()] = $emailTemplate->getLink();
$this->breadcrumbs[] = t('Update');

$this->renderPartial('_menu', array(
    'emailTemplate' => $emailTemplate,
));
$this->renderPartial('_form', array(
    'emailTemplate' => $emailTemplate,
));

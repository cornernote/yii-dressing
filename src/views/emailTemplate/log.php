<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate EmailTemplate
 */

$this->pageTitle = $this->pageHeading = $emailTemplate->getName() . ' - ' . $this->getName() . ' ' . t('Log');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.emailTemplate', array('/emailTemplate/index'));
$this->breadcrumbs[$emailTemplate->getName()] = $emailTemplate->getLink();
$this->breadcrumbs[] = t('Log');

$this->renderPartial('_menu', array(
    'emailTemplate' => $emailTemplate,
));
$this->renderPartial('/auditTrail/_log', array(
    'model' => $emailTemplate,
));

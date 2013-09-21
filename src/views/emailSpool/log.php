<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool YdEmailSpool
 */

$this->pageTitle = $this->pageHeading = $emailSpool->getName() . ' - ' . $this->getName() . ' ' . t('Log');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.emailSpool', array('/emailSpool/index'));
$this->breadcrumbs[$emailSpool->getName()] = $emailSpool->getLink();
$this->breadcrumbs[] = t('Log');

$this->renderPartial('dressing.views.emailSpool._menu', array(
    'emailSpool' => $emailSpool,
));
$this->renderPartial('dressing.views.auditTrail._log', array(
    'model' => $emailSpool,
));

<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool EmailSpool
 */

$this->pageTitle = $this->pageHeading = $emailSpool->getName() . ' - ' . $this->getName() . ' ' . t('Log');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.emailSpool', array('/emailSpool/index'));
$this->breadcrumbs[$emailSpool->getName()] = $emailSpool->getLink();
$this->breadcrumbs[] = t('Log');

$this->renderPartial('_menu', array(
    'emailSpool' => $emailSpool,
));
$this->renderPartial('/auditTrail/_log', array(
    'model' => $emailSpool,
));

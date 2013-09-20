<?php
/**
 * @var $this ContactUsController
 * @var $contactUs ContactUs
 */

$this->pageTitle = $this->pageHeading = $contactUs->getName() . ' - ' . $this->getName() . ' ' . t('Log');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.contactUs', array('/contactUs/index'));
$this->breadcrumbs[$contactUs->getName()] = $contactUs->getUrl();
$this->breadcrumbs[] = t('Log');

$this->renderPartial('_menu', array(
    'contactUs' => $contactUs,
));
$this->renderPartial('/auditTrail/_log', array(
    'model' => $contactUs,
));

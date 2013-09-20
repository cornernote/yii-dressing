<?php
/**
 * @var $this ContactUsController
 * @var $contactUs ContactUs
 */

$this->pageTitle = $this->pageHeading = $contactUs->getName() . ' - ' . $this->getName() . ' ' . t('Update');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.contactUs', array('/contactUs/index'));
$this->breadcrumbs[$contactUs->getName()] = $contactUs->getUrl();
$this->breadcrumbs[] = t('Update');

$this->renderPartial('_menu', array(
    'contactUs' => $contactUs,
));
$this->renderPartial('_form', array(
    'contactUs' => $contactUs,
));

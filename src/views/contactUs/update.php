<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 */

$this->pageTitle = $this->pageHeading = $contactUs->getName() . ' - ' . $this->getName() . ' ' . t('Update');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.contactUs', array('/contactUs/index'));
$this->breadcrumbs[$contactUs->getName()] = $contactUs->getUrl();
$this->breadcrumbs[] = t('Update');

$this->renderPartial('dressing.views.contactUs._menu', array(
    'contactUs' => $contactUs,
));
$this->renderPartial('dressing.views.contactUs._form', array(
    'contactUs' => $contactUs,
));

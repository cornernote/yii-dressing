<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 */

$this->pageTitle = $this->pageHeading = $contactUs->getName() . ' - ' . $this->getName() . ' ' . t('Log');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.contactUs', array('/contactUs/index'));
$this->breadcrumbs[$contactUs->getName()] = $contactUs->getUrl();
$this->breadcrumbs[] = t('Log');

$this->renderPartial('dressing.views.contactUs._menu', array(
    'contactUs' => $contactUs,
));
$this->renderPartial('dressing.views.contactUs._log', array(
    'model' => $contactUs,
));

<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 */

$this->pageTitle = $this->pageHeading = $this->getName();

$this->breadcrumbs = array();

$this->renderPartial('dressing.views.contactUs._form', array(
    'contactUs' => $contactUs,
));

<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 */

$this->pageTitle = $this->pageHeading = $this->getName();
$this->breadcrumbs[] = $this->getName();

$this->renderPartial('dressing.views.contactUs._form', array(
    'contactUs' => $contactUs,
));

<?php
/**
 * @var $this ContactUsController
 * @var $contactUs ContactUs
 */

$this->pageTitle = $this->pageHeading = $contactUs->getName() . ' - ' . $this->getName() . ' ' . t('View');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.contactUs', array('/contactUs/index'));
$this->breadcrumbs[] = $contactUs->getName();

$this->renderPartial('_menu', array(
    'contactUs' => $contactUs,
));

$attributes = array();
$attributes[] = array(
    'name' => 'id',
);
$attributes[] = array(
    'name' => 'name',
);
$attributes[] = array(
    'name' => 'email',
);
$attributes[] = array(
    'name' => 'phone',
);
$attributes[] = array(
    'name' => 'company',
);
$attributes[] = array(
    'name' => 'subject',
);
$attributes[] = array(
    'name' => 'message',
    'type' => 'raw',
);
$attributes[] = array(
    'name' => 'created_at',
);
$attributes[] = array(
    'name' => 'ip_address',
);

$this->widget('widgets.DetailView', array(
    'data' => $contactUs,
    'attributes' => $attributes,
));

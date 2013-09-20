<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool EmailSpool
 */
$this->pageTitle = $this->pageHeading = $emailSpool->getName() . ' - ' . $this->getName() . ' ' . t('View');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.emailSpool', array('/emailSpool/index'));
$this->breadcrumbs[] = $emailSpool->getName();

$this->renderPartial('_menu', array(
    'emailSpool' => $emailSpool,
));

// details
ob_start();
$attributes = array();
$attributes[] = array(
    'name' => 'id',
    'value' => ' emailSpool-' . $emailSpool->id,
);
$attributes[] = 'message_subject';
$attributes[] = 'to_email';
$attributes[] = 'to_name';
$attributes[] = 'status';
$attributes[] = 'model';
$attributes[] = 'model_id';
$attributes[] = 'from_email';
$attributes[] = 'from_name';
$attributes[] = array(
    'name' => 'model_id',
    'value' => $emailSpool->getModelLink(),
    'type' => 'raw',
);
$attributes[] = 'sent';
$this->widget('widgets.DetailView', array(
    'data' => $emailSpool,
    'attributes' => $attributes,
));
$details = ob_get_clean();

// tabs
$this->widget('bootstrap.widgets.TbTabs', array(
    'type' => 'pills', // 'tabs' or 'pills'
    'tabs' => array(
        array('label' => t('Details'), 'content' => $details, 'active' => true),
        array('label' => t('HTML Message'), 'content' => $emailSpool->message_html),
        array('label' => t('Text Message'), 'content' => nl2br($emailSpool->message_text)),
    ),
));
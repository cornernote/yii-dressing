<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool YdEmailSpool
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
$this->pageTitle = $this->pageHeading = $emailSpool->getName();

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Email Spools')] = Yii::app()->user->getState('index.emailSpool', array('/emailSpool/index'));
$this->breadcrumbs[] = $emailSpool->getName();

$this->renderPartial('/emailSpool/_menu', array(
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
    //'value' => $emailSpool->getModelLink(),
    'type' => 'raw',
);
$attributes[] = 'sent';
$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $emailSpool,
    'attributes' => $attributes,
));
$details = ob_get_clean();

// tabs
$this->widget('bootstrap.widgets.TbTabs', array(
    'type' => 'pills', // 'tabs' or 'pills'
    'tabs' => array(
        array('label' => Yii::t('dressing', 'Details'), 'content' => $details, 'active' => true),
        array('label' => Yii::t('dressing', 'HTML Message'), 'content' => $emailSpool->message_html),
        array('label' => Yii::t('dressing', 'Text Message'), 'content' => nl2br($emailSpool->message_text)),
    ),
));
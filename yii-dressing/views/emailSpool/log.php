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
$this->renderPartial('/auditTrail/_log', array(
    'model' => $emailSpool,
));

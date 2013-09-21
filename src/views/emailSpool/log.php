<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool YdEmailSpool
 */

$this->pageTitle = $this->pageHeading = $emailSpool->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'Log');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Email Spools')] = Yii::app()->user->getState('index.emailSpool', array('/emailSpool/index'));
$this->breadcrumbs[$emailSpool->getName()] = $emailSpool->getLink();
$this->breadcrumbs[] = Yii::t('dressing', 'Log');

$this->renderPartial('dressing.views.emailSpool._menu', array(
    'emailSpool' => $emailSpool,
));
$this->renderPartial('dressing.views.auditTrail._log', array(
    'model' => $emailSpool,
));

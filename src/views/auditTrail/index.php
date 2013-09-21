<?php
/**
 * @var $this AuditTrailController
 * @var $auditTrail YdAuditTrail
 */

Yii::app()->user->setState('search.auditTrail', Yii::app()->request->requestUri);
$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Audit Trails');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Audit Trails');

$this->renderPartial('dressing.views.auditTrail._menu');
$this->renderPartial('dressing.views.auditTrail._grid', array('auditTrail' => $auditTrail));
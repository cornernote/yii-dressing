<?php
/**
 * @var $this AuditTrailController
 * @var $auditTrail YdAuditTrail
 */

user()->setState('search.auditTrail', ru());
$this->pageTitle = $this->pageHeading = t('Audit Trails');

$this->breadcrumbs[t('Tools')] = array('/tool/index');
$this->breadcrumbs[] = t('Audit Trails');

$this->renderPartial('dressing.views.auditTrail._menu');
$this->renderPartial('dressing.views.auditTrail._grid', array('auditTrail' => $auditTrail));
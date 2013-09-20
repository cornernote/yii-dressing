<?php
/**
 *@var $this AuditTrailController
 *@var $auditTrail AuditTrail
 */
user()->setState('search.auditTrail', ru());
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('List');
$this->breadcrumbs = array($this->getName() . ' ' . t('List'));
$this->renderPartial('_menu');
$this->renderPartial('/auditTrail/_grid', array('auditTrail' => $auditTrail));
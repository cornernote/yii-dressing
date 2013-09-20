<?php
/**
 * @var $this AuditController
 * @var $audit Audit
 */
user()->setState('index.audit', ru());
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('List');
$this->breadcrumbs = array($this->getName() . ' ' . t('List'));
$this->renderPartial('_menu');
$this->renderPartial('/audit/_grid', array('audit' => $audit));
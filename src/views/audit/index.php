<?php
/**
 * @var $this AuditController
 * @var $audit YdAudit
 */
user()->setState('index.audit', ru());
$this->pageTitle = $this->pageHeading = t('Audits');

$this->breadcrumbs[t('Tools')] = array('/tool/index');
$this->breadcrumbs[] = t('Audits');

$this->renderPartial('dressing.views.audit._menu');
$this->renderPartial('dressing.views.audit._grid', array('audit' => $audit));
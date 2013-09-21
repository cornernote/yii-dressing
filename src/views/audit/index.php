<?php
/**
 * @var $this AuditController
 * @var $audit YdAudit
 */
Yii::app()->user->setState('index.audit', Yii::app()->request->requestUri);
$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Audits');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Audits');

$this->renderPartial('dressing.views.audit._menu');
$this->renderPartial('dressing.views.audit._grid', array('audit' => $audit));
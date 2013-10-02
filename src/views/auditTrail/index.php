<?php
/**
 * @var $this AuditTrailController
 * @var $auditTrail YdAuditTrail
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

Yii::app()->user->setState('search.auditTrail', Yii::app()->request->requestUri);
$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Audit Trails');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Audit Trails');

$this->renderPartial('dressing.views.auditTrail._menu');
$this->renderPartial('dressing.views.auditTrail._grid', array('auditTrail' => $auditTrail));
<?php
/**
 * @var $this YdAuditTrailController
 * @var $auditTrail YdAuditTrail
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

Yii::app()->user->setState('search.auditTrail', Yii::app()->request->requestUri);
$this->pageTitle = Yii::t('dressing', 'Audit Trails');

$this->renderPartial('/auditTrail/_menu');
$this->renderPartial('/auditTrail/_grid', array('auditTrail' => $auditTrail));
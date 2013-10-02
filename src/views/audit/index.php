<?php
/**
 * @var $this AuditController
 * @var $audit YdAudit
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */
Yii::app()->user->setState('index.audit', Yii::app()->request->requestUri);
$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Audits');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Audits');

$this->renderPartial('dressing.views.audit._menu');
$this->renderPartial('dressing.views.audit._grid', array('audit' => $audit));
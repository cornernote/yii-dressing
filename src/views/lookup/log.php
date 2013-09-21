<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 */

$this->pageTitle = $this->pageHeading = $lookup->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'Log');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Lookups')] = Yii::app()->user->getState('index.lookup', array('/lookup/index'));
$this->breadcrumbs[$lookup->getName()] = $lookup->getLink();
$this->breadcrumbs[] = Yii::t('dressing', 'Log');

$this->renderPartial('dressing.views.lookup._menu', array(
    'lookup' => $lookup,
));
$this->renderPartial('dressing.views.auditTrail._log', array(
    'model' => $lookup,
));

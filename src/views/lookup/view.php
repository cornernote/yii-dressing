<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 */

$this->pageTitle = $this->pageHeading = $lookup->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'View');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Lookups')] = Yii::app()->user->getState('index.lookup', array('/lookup/index'));
$this->breadcrumbs[] = $lookup->getName();

$this->renderPartial('dressing.views.lookup._menu', array(
    'lookup' => $lookup,
));

$attributes = array();
$attributes[] = 'id';
$attributes[] = 'name';
$attributes[] = 'type';
$attributes[] = 'position';
$attributes[] = 'created';
$attributes[] = 'deleted';

$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $lookup,
    'attributes' => $attributes,
));

<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'Create');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Lookups')] = Yii::app()->user->getState('index.lookup', array('/lookup/index'));
$this->breadcrumbs[] = Yii::t('dressing', 'Create');

$this->renderPartial('dressing.views.lookup._menu', array(
    'lookup' => $lookup,
));
$this->renderPartial('dressing.views.lookup._form', array(
    'lookup' => $lookup,
));

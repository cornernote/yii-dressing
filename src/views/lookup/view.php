<?php
/**
 * @var $this LookupController
 * @var $lookup Lookup
 */

$this->pageTitle = $this->pageHeading = $lookup->getName() . ' - ' . $this->getName() . ' ' . t('View');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.lookup', array('/lookup/index'));
$this->breadcrumbs[] = $lookup->getName();

$this->renderPartial('_menu', array(
    'lookup' => $lookup,
));

$attributes = array();
$attributes[] = 'id';
$attributes[] = 'name';
$attributes[] = 'type';
$attributes[] = 'position';
$attributes[] = 'created';
$attributes[] = 'deleted';

$this->widget('widgets.DetailView', array(
    'data' => $lookup,
    'attributes' => $attributes,
));

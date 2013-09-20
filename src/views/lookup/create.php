<?php
/**
 * @var $this LookupController
 * @var $lookup Lookup
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('Create');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.lookup', array('/lookup/index'));
$this->breadcrumbs[] = t('Create');

$this->renderPartial('_menu', array(
    'lookup' => $lookup,
));
$this->renderPartial('_form', array(
    'lookup' => $lookup,
));

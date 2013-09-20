<?php
/**
 * @var $this LookupController
 * @var $lookup Lookup
 */

$this->pageTitle = $this->pageHeading = $lookup->getName() . ' - ' . $this->getName() . ' ' . t('Log');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.lookup', array('/lookup/index'));
$this->breadcrumbs[$lookup->getName()] = $lookup->getLink();
$this->breadcrumbs[] = t('Log');

$this->renderPartial('_menu', array(
    'lookup' => $lookup,
));
$this->renderPartial('/auditTrail/_log', array(
    'model' => $lookup,
));

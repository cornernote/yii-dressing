<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 */

$this->pageTitle = $this->pageHeading = $lookup->getName() . ' - ' . $this->getName() . ' ' . t('Log');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.lookup', array('/lookup/index'));
$this->breadcrumbs[$lookup->getName()] = $lookup->getLink();
$this->breadcrumbs[] = t('Log');

$this->renderPartial('dressing.views.lookup._menu', array(
    'lookup' => $lookup,
));
$this->renderPartial('dressing.views.auditTrail._log', array(
    'model' => $lookup,
));

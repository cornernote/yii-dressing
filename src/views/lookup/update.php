<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 */

$this->pageTitle = $this->pageHeading = $lookup->getName() . ' - ' . $this->getName() . ' ' . t('Update');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.lookup', array('/lookup/index'));
$this->breadcrumbs[$lookup->getName()] = $lookup->getLink();
$this->breadcrumbs[] = t('Update');

$this->renderPartial('dressing.views.lookup._menu', array(
    'lookup' => $lookup,
));
$this->renderPartial('dressing.views.lookup._form', array(
    'lookup' => $lookup,
));

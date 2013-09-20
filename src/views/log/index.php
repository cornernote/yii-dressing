<?php
/**
 * @var $this LogController
 * @var $log Log
 */
user()->setState('index.log', ru());
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('List');
$this->breadcrumbs = array($this->getName() . ' ' . t('List'));
$this->renderPartial('_menu');
$this->renderPartial('/log/_grid', array('log' => $log));
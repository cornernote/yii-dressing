<?php
/**
 * @var $this NoteController
 * @var $note Note
 */

$this->pageTitle = $this->pageHeading = $note->getName() . ' - ' . $this->getName() . ' ' . t('Log');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.note', array('/note/index'));
$this->breadcrumbs[$note->getName()] = $note->getLink();
$this->breadcrumbs[] = t('Log');

$this->renderPartial('_menu', array(
    'note' => $note,
));
$this->renderPartial('/auditTrail/_log', array(
    'model' => $note,
));

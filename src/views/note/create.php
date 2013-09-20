<?php
/**
 * @var $this NoteController
 * @var $note Note
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('Create');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.note', array('/note/index'));
$this->breadcrumbs[] = t('Create');

$this->renderPartial('_menu', array(
    'note' => $note,
));
$this->renderPartial('_form', array(
    'note' => $note,
));

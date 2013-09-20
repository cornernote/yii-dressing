<?php
/**
 * @var $this NoteController
 * @var $note Note
 */

$this->pageTitle = $this->pageHeading = $note->getName() . ' - ' . $this->getName() . ' ' . t('Update');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.note', array('/note/index'));
$this->breadcrumbs[$note->getName()] = $note->getLink();
$this->breadcrumbs[] = t('Update');

$this->renderPartial('_menu', array(
    'note' => $note,
));
$this->renderPartial('_form', array(
    'note' => $note,
));

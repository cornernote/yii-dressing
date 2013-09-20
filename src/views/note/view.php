<?php
/**
 * @var $this NoteController
 * @var $note Note
 */

$this->pageTitle = $this->pageHeading = $note->getName() . ' - ' . $this->getName() . ' ' . t('View');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.note', array('/note/index'));
$this->breadcrumbs[] = $note->getName();

$this->renderPartial('_menu', array(
    'note' => $note,
));

$attributes = array();
$attributes[] = 'id';
$attributes[] = 'notes';
$attributes[] = 'model';
$attributes[] = 'model_id';
$attributes[] = 'sort_order';
$attributes[] = 'important';
$attributes[] = 'created';
$attributes[] = 'deleted';

$this->widget('widgets.DetailView', array(
    'data' => $note,
    'attributes' => $attributes,
));

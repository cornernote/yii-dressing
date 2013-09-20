<?php
/**
 * @var $this NoteController
 * @var $note Note
 */

$columns = array();
$columns[] = array(
    'name' => 'id',
    'class' => 'widgets.TbDropdownColumn',
);
$columns[] = array(
    'name' => 'notes',
);
$columns[] = array(
    'name' => 'model',
);
$columns[] = array(
    'name' => 'model_id',
);
$columns[] = array(
    'name' => 'sort_order',
);
$columns[] = array(
    'name' => 'important',
);
		/*
$columns[] = array(
    'name' => 'created',
);
$columns[] = array(
    'name' => 'deleted',
);
		*/

// multi actions
$multiActions = array();
$multiActions[] = array(
    'name' => t('Delete'),
    'url' => url('/note/delete'),
);

// grid
$this->widget('widgets.GridView', array(
    'id' => 'note-grid',
    'dataProvider' => $note->search(),
    'filter' => $note,
    'columns' => $columns,
    'multiActions' => $multiActions,
));

<?php
/**
 * @var $this LookupController
 * @var $lookup Lookup
 */

$columns = array();
$columns[] = array(
    'name' => 'id',
    'class' => 'widgets.TbDropdownColumn',
);
$columns[] = array(
    'name' => 'name',
);
$columns[] = array(
    'name' => 'type',
);
$columns[] = array(
    'name' => 'position',
);
$columns[] = array(
    'name' => 'created',
);
$columns[] = array(
    'name' => 'deleted',
);

// multi actions
$multiActions = array();
$multiActions[] = array(
    'name' => t('Delete'),
    'url' => url('/lookup/delete'),
);

// grid
$this->widget('widgets.GridView', array(
    'id' => 'lookup-grid',
    'dataProvider' => $lookup->search(),
    'filter' => $lookup,
    'columns' => $columns,
    'multiActions' => $multiActions,
));

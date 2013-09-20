<?php
$columns = array();
if ($this->id != 'user') {
    $columns[] = array(
        'name' => 'user_id',
        'value' => '$data->user?$data->audit->getLink():null',
        'type' => 'raw',
    );
}
if ($this->id != 'audit') {
    $columns[] = array(
        'name' => 'audit_id',
        'value' => '$data->audit?$data->audit->getLink():null',
        'type' => 'raw',
    );
}
$columns[] = array(
    'name' => 'action',
);
if (in_array($this->id, array('auditTrail', 'audit'))) {
    $columns[] = array(
        'name' => 'model',
    );
    $columns[] = array(
        'name' => 'model_id',
        'header' => t('Id'),
    );
}
$columns[] = array(
    'name' => 'field',
);
$columns[] = array(
    'name' => 'old_value',
    'value' => '$data->oldValueString',
    'type' => 'raw',
);
$columns[] = array(
    'name' => 'new_value',
    'value' => '$data->newValueString',
    'type' => 'raw',
);
$columns[] = array(
    'name' => 'created',
    'value' => '$data->created',
    'type' => 'raw',
    'htmlOptions' => array('style' => 'width:150px'),
);

// grid
$this->widget('widgets.GridView', array(
    'id' => 'auditTrail-grid',
    'dataProvider' => $auditTrail->search(),
    'filter' => $auditTrail,
    'columns' => $columns,
));
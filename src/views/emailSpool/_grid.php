<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool YdEmailSpool
 */

$columns = array();
$columns[] = array(
    'name' => 'id',
    'class' => 'dressing.widgets.YdDropdownColumn',
);
$columns[] = array(
    'name' => 'model',
    //'filter' => array(),
);
$columns[] = 'model_id';
$columns[] = array(
    'name' => 'type',
    //'filter' => array(),
);
$columns[] = array(
    'name' => 'message_subject',
    'type' => 'raw',
    'value' => '"<b>".h($data->message_subject)."</b>"',
);
$columns[] = 'to_name';
$columns[] = 'to_email';
$columns[] = array(
    'name' => 'status',
    'type' => 'raw',
    'value' => '$data->status',
);
$columns[] = array(
    'name' => 'sent',
    'type' => 'raw',
    'value' => 'Time::agoIcon($data->sent)',
);
$columns[] = array(
    'name' => 'created',
    'type' => 'raw',
    'value' => 'Time::agoIcon($data->created)',
);

// grid
$this->widget('dressing.widgets.YdGridView', array(
    'id' => 'emailSpool-grid',
    'dataProvider' => $emailSpool->search(),
    'filter' => $emailSpool,
    'columns' => $columns,
));

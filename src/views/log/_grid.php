<?php
/**
 * @var $this LogController
 * @var $log Log
 */

// columns
$columns = array();

$columns[] = array(
    'name' => 'id',
    'class' => 'widgets.TbDropdownColumn',
);
$columns[] = array(
    'name' => 'message',
);
$columns[] = array(
    'name' => 'details',
    'value' => 'print_r(unserialize($data->details),true)',
);
$columns[] = array(
    'name' => 'model',
    'header' => t('model'),
    'value' => '$data->model',
    'htmlOptions' => array('style' => 'width:70px'),
);
$columns[] = array(
    'name' => 'model_id',
    'header' => t('Model ID'),
    'value' => '$data->model_id',
    'htmlOptions' => array('style' => 'width:70px'),
);
$columns[] = array(
    'name' => 'user_id',
    'type' => 'raw',
    'value' => '$data->user?l(h($data->user->name),$data->user->url):null',
    'htmlOptions' => array('style' => 'width:105px'),
);
$columns[] = array(
    'name' => 'created',
    'value' => '$data->created',
    'type' => 'raw',
    'htmlOptions' => array('style' => 'width:150px'),
);
$columns[] = array(
    'name' => 'ip',
    'htmlOptions' => array('style' => 'width:100px'),
);

// grid
$this->widget('widgets.GridView', array(
    'id' => 'log-grid',
    'dataProvider' => $log->search(),
    'filter' => $log,
    'columns' => $columns,
));

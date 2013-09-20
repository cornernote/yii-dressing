<?php
/**
 * @var $audit Audit
 */
$columns = array();
$columns[] = array(
    'name' => 'id',
    'class' => 'widgets.TbDropdownColumn',
);
$columns[] = array(
    'name' => 'user_id',
    'type' => 'raw',
    'value' => '$data->user?l(h($data->user->name),$data->user->url):null',
    'htmlOptions' => array('style' => 'width:105px'),
);
$columns[] = array(
    'name' => 'link',
    'value' => '$data->getLinkString()',
    'type' => 'raw',
);
$columns[] = array(
    'header' => t('Audits'),
    'name' => 'audit_trail_count',
    'value' => '$data->audit_trail_count?$data->audit_trail_count:null',
    'htmlOptions' => array('style' => 'width:50px'),
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
$columns[] = array(
    'name' => 'yii_version',
    'header' => 'Yii',
    'value' => '$data->showYiiVersion()',
    'type' => 'raw',
    'htmlOptions' => array('style' => 'width:50px'),
);
$columns[] = array(
    'name' => 'app_version',
    'header' => 'App',
    'value' => '$data->showAppVersion()',
    'type' => 'raw',
    'htmlOptions' => array('style' => 'width:40px'),
);
$columns[] = array(
    'name' => 'total_time',
    'header' => t('Time'),
    'value' => 'number_format($data->total_time,3)',
    'htmlOptions' => array('style' => 'width:60px'),
);
$columns[] = array(
    'name' => 'memory_peak',
    'header' => t('Peak'),
    'value' => 'number_format($data->memory_peak/1024/1024,2)',
    'htmlOptions' => array('style' => 'width:70px'),
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

// grid
$this->widget('widgets.GridView', array(
    'id' => 'audit-grid',
    'dataProvider' => $audit->search(),
    'filter' => $audit,
    'columns' => $columns,
));
<?php
/**
 * @var $audit YdAudit
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
$columns = array();
$columns[] = array(
    'name' => 'id',
    'class' => 'dressing.widgets.YdDropdownColumn',
);
$columns[] = array(
    'name' => 'user_id',
    'type' => 'raw',
    'value' => '$data->user?CHtml::link(h($data->user->name),$data->user->url):null',
    'htmlOptions' => array('style' => 'width:105px'),
);
$columns[] = array(
    'name' => 'link',
    'value' => '$data->getLinkString()',
    'type' => 'raw',
);
$columns[] = array(
    'header' => Yii::t('dressing', 'Audits'),
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
    'name' => 'total_time',
    'header' => Yii::t('dressing', 'Time'),
    'value' => 'number_format($data->total_time,3)',
    'htmlOptions' => array('style' => 'width:60px'),
);
$columns[] = array(
    'name' => 'memory_peak',
    'header' => Yii::t('dressing', 'Peak'),
    'value' => 'number_format($data->memory_peak/1024/1024,2)',
    'htmlOptions' => array('style' => 'width:70px'),
);

// grid
$this->widget('dressing.widgets.YdGridView', array(
    'id' => 'audit-grid',
    'dataProvider' => $audit->search(),
    'filter' => $audit,
    'columns' => $columns,
));
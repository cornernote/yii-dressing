<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool YdEmailSpool
 * @var $hideModel bool
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

$columns = array();
$columns[] = array(
    'name' => 'id',
    'class' => 'dressing.widgets.YdDropdownColumn',
);
if (empty($hideModel)) {
    $columns[] = array(
        'name' => 'model',
        //'filter' => array(),
    );
    $columns[] = 'model_id';
}
$columns[] = array(
    'name' => 'template',
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

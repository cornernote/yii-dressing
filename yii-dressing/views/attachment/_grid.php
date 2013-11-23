<?php
/**
 * @var $this AttachmentController
 * @var $attachment YdAttachment
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
$columns[] = array(
    'name' => 'model',
);
$columns[] = array(
    'name' => 'model_id',
);
$columns[] = array(
    'name' => 'filename',
);
$columns[] = array(
    'name' => 'extension',
);
$columns[] = array(
    'name' => 'filetype',
);
		/*
$columns[] = array(
    'name' => 'filesize',
);
$columns[] = array(
    'name' => 'notes',
);
$columns[] = array(
    'name' => 'sort_order',
);
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
    'name' => Yii::t('dressing', 'Delete'),
    'url' => Yii::app()->createUrl('/attachment/delete'),
);

// grid
$this->widget('dressing.widgets.YdGridView', array(
    'id' => 'attachment-grid',
    'dataProvider' => $attachment->search(),
    'filter' => $attachment,
    'columns' => $columns,
    'multiActions' => $multiActions,
));

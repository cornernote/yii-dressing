<?php
/**
 * @var $this AttachmentController
 * @var $attachment Attachment
 */

$columns = array();
$columns[] = array(
    'name' => 'id',
    'class' => 'widgets.TbDropdownColumn',
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
    'name' => t('Delete'),
    'url' => url('/attachment/delete'),
);

// grid
$this->widget('widgets.GridView', array(
    'id' => 'attachment-grid',
    'dataProvider' => $attachment->search(),
    'filter' => $attachment,
    'columns' => $columns,
    'multiActions' => $multiActions,
));

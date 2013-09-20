<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate EmailTemplate
 */

$columns = array();
if (user()->checkAccess('admin')) {
    $columns[] = array(
        'name' => 'id',
        'htmlOptions' => array('width' => '80'),
    );
}

$columns[] = array(
    'name' => 'name',
    'value' => '$data->getLink(array("update"))',
    'type' => 'raw',
);
$columns[] = array(
    'name' => 'message_subject',
);
$columns[] = array(
    'name' => 'message_html',
    'type' => 'raw',
    'filter' => false,
);
$columns[] = array(
    'name' => 'message_text',
    'type' => 'raw',
    'filter' => false,
);
$columns[] = array(
    'name' => 'description',
    'filter' => false,
);

// grid
$this->widget('widgets.GridView', array(
    'id' => 'emailTemplate-grid',
    'dataProvider' => $emailTemplate->search(),
    'filter' => $emailTemplate,
    'columns' => $columns,
));


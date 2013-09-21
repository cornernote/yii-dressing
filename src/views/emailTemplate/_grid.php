<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate YdEmailTemplate
 */

$columns = array();
$columns[] = array(
    'name' => 'id',
    'class' => 'dressing.widgets.YdDropdownColumn',
    'value' => '$data->getIdString()',
);
$columns[] = array(
    'name' => 'name',
);
$columns[] = array(
    'name' => 'message_subject',
);

// grid
$this->widget('dressing.widgets.YdGridView', array(
    'id' => 'emailTemplate-grid',
    'dataProvider' => $emailTemplate->search(),
    'filter' => $emailTemplate,
    'columns' => $columns,
));


<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 */

$columns = array();
$columns[] = array(
    'name' => 'id',
    'class' => 'dressing.widgets.YdDropdownColumn',
);
$columns[] = array(
    'name' => 'name',
);
$columns[] = array(
    'name' => 'email',
);
$columns[] = array(
    'name' => 'phone',
);
$columns[] = array(
    'name' => 'company',
);
$columns[] = array(
    'name' => 'subject',
);
		/*
$columns[] = array(
    'name' => 'message',
);
$columns[] = array(
    'name' => 'created_at',
);
$columns[] = array(
    'name' => 'ip_address',
);
		*/

// multi actions
$multiActions = array();
$multiActions[] = array(
    'name' => t('Delete'),
    'url' => url('/contactUs/delete'),
);

// grid
$this->widget('dressing.widgets.YdGridView', array(
    'id' => 'contactUs-grid',
    'dataProvider' => $contactUs->search(),
    'filter' => $contactUs,
    'columns' => $columns,
    'multiActions' => $multiActions,
));

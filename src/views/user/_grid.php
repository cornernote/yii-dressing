<?php
/**
 * @var $this UserController
 * @var $user User
 */

$columns = array();
$columns[] = array(
	'name' => 'id',
	'class' => 'widgets.TbDropdownColumn',
);

$columns[] = array(
    'name' => 'email',
    'value' => '$data->email ? l($data->email, "mailto:" . $data->email) : null',
    'type' => 'raw',
);
$columns[] = array(
    'name' => 'phone',
    'filter' => false,
);

if (!$user->role_id) {
    $columns[] = array(
        'name' => 'role_id',
        'value' => 'implode(", ",CHtml::listData($data->role,"id","name"))',
        'filter' => CHtml::listData(Role::model()->findAll(), 'id', 'name'),
        'type' => 'raw',
    );
}


// multi actions
$multiActions = array();
$multiActions[] = array(
    'name' => t('Delete'),
    'url' => url('/user/delete'),
);

// grid
$this->widget('widgets.GridView', array(
    'id' => 'user-grid',
    'dataProvider' => $user->search(),
    'filter' => $user,
    'columns' => $columns,
    'multiActions' => $multiActions,
));


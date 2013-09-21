<?php
/**
 * @var $this UserController
 * @var $user YdUser
 */

$columns = array();
$columns[] = array(
	'name' => 'id',
	'class' => 'dressing.widgets.YdDropdownColumn',
    'value' => '$data->getIdString()',
);

$columns[] = array(
    'name' => 'email',
    'value' => '$data->email ? CHtml::link($data->email, "mailto:" . $data->email) : null',
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
        'filter' => CHtml::listData(YdRole::model()->findAll(), 'id', 'name'),
        'type' => 'raw',
    );
}


// multi actions
$multiActions = array();
$multiActions[] = array(
    'name' => Yii::t('dressing', 'Delete'),
    'url' => Yii::app()->createUrl('/user/delete'),
);

// grid
$this->widget('dressing.widgets.YdGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $user->search(),
    'filter' => $user,
    'columns' => $columns,
    'multiActions' => $multiActions,
));


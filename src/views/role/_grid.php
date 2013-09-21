<?php
/**
 * @var $this RoleController
 * @var $role YdRole
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

// multi actions
$multiActions = array();
$multiActions[] = array(
    'name' => Yii::t('dressing', 'Delete'),
    'url' => Yii::app()->createUrl('/role/delete'),
);

// grid
$this->widget('dressing.widgets.YdGridView', array(
    'id' => 'role-grid',
    'dataProvider' => $role->search(),
    'filter' => $role,
    'columns' => $columns,
    'multiActions' => $multiActions,
));

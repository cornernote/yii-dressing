<?php
/**
 * @var $this UserController
 * @var $user YdUser
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


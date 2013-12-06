<?php
/**
 * @var $this RoleController
 * @var $role YdRole
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
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

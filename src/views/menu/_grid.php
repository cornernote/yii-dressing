<?php
/**
 * @var $this MenuController
 * @var $menu YdMenu
 */

$columns = array();
$columns[] = array(
    'name' => 'id',
    'class' => 'dressing.widgets.YdDropdownColumn',
);
$columns[] = array(
    'name' => 'parent_id',
);
$columns[] = array(
    'name' => 'label',
);
$columns[] = array(
    'name' => 'icon',
);
$columns[] = array(
    'name' => 'url',
);
$columns[] = array(
    'name' => 'url_params',
);
		/*
$columns[] = array(
    'name' => 'target',
);
$columns[] = array(
    'name' => 'access_role',
);
$columns[] = array(
    'name' => 'created',
);
$columns[] = array(
    'name' => 'deleted',
);
$columns[] = array(
    'name' => 'sort_order',
);
$columns[] = array(
    'name' => 'enabled',
);
		*/

// multi actions
$multiActions = array();
$multiActions[] = array(
    'name' => Yii::t('dressing', 'Delete'),
    'url' => Yii::app()->createUrl('/menu/delete'),
);

// grid
$this->widget('dressing.widgets.YdGridView', array(
    'id' => 'menu-grid',
    'dataProvider' => $menu->search(),
    'filter' => $menu,
    'columns' => $columns,
    'multiActions' => $multiActions,
));

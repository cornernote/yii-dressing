<?php
/**
 * @var $this MenuController
 * @var $menu Menu
 */

$columns = array();
$columns[] = array(
    'name' => 'id',
    'class' => 'widgets.TbDropdownColumn',
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
    'name' => t('Delete'),
    'url' => url('/menu/delete'),
);

// grid
$this->widget('widgets.GridView', array(
    'id' => 'menu-grid',
    'dataProvider' => $menu->search(),
    'filter' => $menu,
    'columns' => $columns,
    'multiActions' => $multiActions,
));

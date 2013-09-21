<?php
/**
 * @var $this MenuController
 * @var $menu YdMenu
 */

// list
$this->widget('dressing.widgets.YdListView', array(
    'id' => 'menu-list',
    'dataProvider' => $menu->search(),
    'itemView' => 'dressing.views.menu._list_view',
));

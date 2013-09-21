<?php
/**
 * @var $this MenuController
 * @var $menu YdMenu
 */

// list
$this->widget('widgets.ListView', array(
    'id' => 'menu-list',
    'dataProvider' => $menu->search(),
    'itemView' => '_list_view',
));

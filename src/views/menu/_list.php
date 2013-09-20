<?php
/**
 * @var $this MenuController
 * @var $menu Menu
 */

// list
$this->widget('widgets.ListView', array(
    'id' => 'menu-list',
    'dataProvider' => $menu->search(),
    'itemView' => '_list_view',
));

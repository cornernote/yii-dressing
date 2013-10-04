<?php
/**
 * @var $this MenuController
 * @var $menu YdMenu
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

// list
$this->widget('dressing.widgets.YdListView', array(
    'id' => 'menu-list',
    'dataProvider' => $menu->search(),
    'itemView' => 'dressing.views.menu._list_view',
));

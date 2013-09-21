<?php
/**
 * @var $this RoleController
 * @var $role YdRole
 */

// list
$this->widget('dressing.widgets.YdListView', array(
    'id' => 'role-list',
    'dataProvider' => $role->search(),
    'itemView' => 'dressing.views.role._list_view',
));

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

// list
$this->widget('dressing.widgets.YdListView', array(
    'id' => 'role-list',
    'dataProvider' => $role->search(),
    'itemView' => '/role/_list_view',
));

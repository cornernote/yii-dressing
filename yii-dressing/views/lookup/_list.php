<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

// list
$this->widget('dressing.widgets.YdListView', array(
    'id' => 'lookup-list',
    'dataProvider' => $lookup->search(),
    'itemView' => 'dressing.views.lookup._list_view',
));

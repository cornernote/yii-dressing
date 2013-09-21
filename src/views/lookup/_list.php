<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 */

// list
$this->widget('dressing.widgets.YdListView', array(
    'id' => 'lookup-list',
    'dataProvider' => $lookup->search(),
    'itemView' => 'dressing.views.lookup._list_view',
));

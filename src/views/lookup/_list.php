<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 */

// list
$this->widget('widgets.ListView', array(
    'id' => 'lookup-list',
    'dataProvider' => $lookup->search(),
    'itemView' => '_list_view',
));

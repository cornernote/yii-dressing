<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 */

// list
$this->widget('dressing.widgets.YdListView', array(
    'id' => 'contactUs-list',
    'dataProvider' => $contactUs->search(),
    'itemView' => 'dressing.views.contactUs._list_view',
));

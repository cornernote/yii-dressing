<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 */

// list
$this->widget('widgets.ListView', array(
    'id' => 'contactUs-list',
    'dataProvider' => $contactUs->search(),
    'itemView' => '_list_view',
));

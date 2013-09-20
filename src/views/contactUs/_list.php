<?php
/**
 * @var $this ContactUsController
 * @var $contactUs ContactUs
 */

// list
$this->widget('widgets.ListView', array(
    'id' => 'contactUs-list',
    'dataProvider' => $contactUs->search(),
    'itemView' => '_list_view',
));

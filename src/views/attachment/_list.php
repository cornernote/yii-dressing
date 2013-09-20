<?php
/**
 * @var $this AttachmentController
 * @var $attachment Attachment
 */

// list
$this->widget('widgets.ListView', array(
    'id' => 'attachment-list',
    'dataProvider' => $attachment->search(),
    'itemView' => '_list_view',
));

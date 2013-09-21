<?php
/**
 * @var $this AttachmentController
 * @var $attachment YdAttachment
 */

// list
$this->widget('dressing.widgets.YdListView', array(
    'id' => 'attachment-list',
    'dataProvider' => $attachment->search(),
    'itemView' => 'dressing.views.attachment._list_view',
));

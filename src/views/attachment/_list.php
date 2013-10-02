<?php
/**
 * @var $this AttachmentController
 * @var $attachment YdAttachment
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

// list
$this->widget('dressing.widgets.YdListView', array(
    'id' => 'attachment-list',
    'dataProvider' => $attachment->search(),
    'itemView' => 'dressing.views.attachment._list_view',
));

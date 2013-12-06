<?php
/**
 * @var $this YdAttachmentController
 * @var $attachment YdAttachment
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

// list
$this->widget('dressing.widgets.YdListView', array(
    'id' => 'attachment-list',
    'dataProvider' => $attachment->search(),
    'itemView' => '/attachment/_list_view',
));

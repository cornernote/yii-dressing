<?php
/**
 * @var $this YdAttachmentController
 * @var $attachment YdAttachment
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

$this->pageTitle = $attachment->getName();

$this->renderPartial('/attachment/_menu', array(
    'attachment' => $attachment,
));

$attributes = array();
$attributes[] = 'id';
$attributes[] = 'model';
$attributes[] = 'model_id';
$attributes[] = 'filename';
$attributes[] = 'extension';
$attributes[] = 'filetype';
$attributes[] = 'filesize';
$attributes[] = 'notes';
$attributes[] = 'sort_order';
$attributes[] = 'created';
$attributes[] = 'deleted';

$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $attachment,
    'attributes' => $attributes,
));

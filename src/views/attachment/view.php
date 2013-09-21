<?php
/**
 * @var $this AttachmentController
 * @var $attachment YdAttachment
 */

$this->pageTitle = $this->pageHeading = $attachment->getName() . ' - ' . $this->getName() . ' ' . t('View');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.attachment', array('/attachment/index'));
$this->breadcrumbs[] = $attachment->getName();

$this->renderPartial('dressing.views.attachment._menu', array(
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

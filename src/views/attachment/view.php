<?php
/**
 * @var $this AttachmentController
 * @var $attachment Attachment
 */

$this->pageTitle = $this->pageHeading = $attachment->getName() . ' - ' . $this->getName() . ' ' . t('View');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.attachment', array('/attachment/index'));
$this->breadcrumbs[] = $attachment->getName();

$this->renderPartial('_menu', array(
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

$this->widget('widgets.DetailView', array(
    'data' => $attachment,
    'attributes' => $attributes,
));

<?php
/**
 * @var $this AttachmentController
 * @var $attachment Attachment
 */

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('Create');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.attachment', array('/attachment/index'));
$this->breadcrumbs[] = t('Create');

$this->renderPartial('_menu', array(
    'attachment' => $attachment,
));
$this->renderPartial('_form', array(
    'attachment' => $attachment,
));

<?php
/**
 * @var $this AttachmentController
 * @var $attachment Attachment
 */

$this->pageTitle = $this->pageHeading = $attachment->getName() . ' - ' . $this->getName() . ' ' . t('Update');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.attachment', array('/attachment/index'));
$this->breadcrumbs[$attachment->getName()] = $attachment->getLink();
$this->breadcrumbs[] = t('Update');

$this->renderPartial('_menu', array(
    'attachment' => $attachment,
));
$this->renderPartial('_form', array(
    'attachment' => $attachment,
));

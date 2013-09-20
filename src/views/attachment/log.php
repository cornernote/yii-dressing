<?php
/**
 * @var $this AttachmentController
 * @var $attachment Attachment
 */

$this->pageTitle = $this->pageHeading = $attachment->getName() . ' - ' . $this->getName() . ' ' . t('Log');

$this->breadcrumbs = array();
$this->breadcrumbs[$this->getName() . ' ' . t('List')] = user()->getState('index.attachment', array('/attachment/index'));
$this->breadcrumbs[$attachment->getName()] = $attachment->getLink();
$this->breadcrumbs[] = t('Log');

$this->renderPartial('_menu', array(
    'attachment' => $attachment,
));
$this->renderPartial('/auditTrail/_log', array(
    'model' => $attachment,
));

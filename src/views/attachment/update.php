<?php
/**
 * @var $this AttachmentController
 * @var $attachment YdAttachment
 */

$this->pageTitle = $this->pageHeading = $attachment->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'Update');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Attachments')] = Yii::app()->user->getState('index.attachment', array('/attachment/index'));
$this->breadcrumbs[$attachment->getName()] = $attachment->getLink();
$this->breadcrumbs[] = Yii::t('dressing', 'Update');

$this->renderPartial('dressing.views.attachment._menu', array(
    'attachment' => $attachment,
));
$this->renderPartial('dressing.views.attachment._form', array(
    'attachment' => $attachment,
));

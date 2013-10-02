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

$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'Create');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Attachments')] = Yii::app()->user->getState('index.attachment', array('/attachment/index'));
$this->breadcrumbs[] = Yii::t('dressing', 'Create');

$this->renderPartial('dressing.views.attachment._menu', array(
    'attachment' => $attachment,
));
$this->renderPartial('_form', array(
    'attachment' => $attachment,
));

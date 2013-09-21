<?php
/**
 * @var $this AttachmentController
 * @var $attachment YdAttachment
 */


// quick upload
if ($attachment->isNewRecord) {
    echo '<h3>' . Yii::t('dressing', 'Multi File Upload') . '</h3>';
    Yii::app()->clientScript->registerCssFile(Yii::app()->dressing->assetUrl . '/swfupload/default.css', 'screen, projection');
    $time = time();
    $uploadUrl = Yii::app()->createUrl('/attachment/create', array(
        'id' => $this->id,
        'model' => $attachment->model,
        'foreign_key' => $attachment->foreign_key,
        'time' => $time,
        'user_id' => Yii::app()->user->id,
        'key' => md5('s3creth#sh' . $time . $attachment->model . $attachment->foreign_key . Yii::app()->user->id),
    ));
    $this->widget('SwfUpload', array(
        'jsHandlerUrl' => Yii::app()->dressing->assetUrl . '/swfupload/handlers.js',
        'postParams' => array(),
        'config' => array(
            'use_query_string' => true,
            'upload_url' => $uploadUrl,
            'file_size_limit' => '50 MB',
            'file_types' => '*.jpg;*.png;*.gif;*.pdf;*.zip',
            'file_types_description' => 'Files',
            'file_upload_limit' => 0,
            'file_queue_error_handler' => 'js:fileQueueError',
            'file_dialog_complete_handler' => 'js:fileDialogComplete',
            'upload_progress_handler' => 'js:uploadProgress',
            'upload_error_handler' => 'js:uploadError',
            'upload_success_handler' => 'js:uploadSuccess',
            'upload_complete_handler' => 'js:uploadComplete',
            'custom_settings' => array('upload_target' => 'divFileProgressContainer'),
            'button_placeholder_id' => 'swfupload',
            'button_image_url' => Yii::app()->dressing->assetUrl . '/swfupload/images/upload.png',
            'button_width' => 61,
            'button_height' => 22,
            'button_window_mode' => 'js:SWFUpload.WINDOW_MODE.TRANSPARENT',
            'button_cursor' => 'js:SWFUpload.CURSOR.HAND',
        ),
    ));
    echo '<div id="divFileProgressContainer"></div>';
    echo '<div class="swfupload"><span id="swfupload"></span></div>';
    echo '<div class="spacer"></div>';
}

// single upload
/** @var YdActiveForm $form */
$form = $this->beginWidget('dressing.widgets.YdActiveForm', array(
    'id' => 'attachment-form',
    'type' => 'horizontal',
    //'enableAjaxValidation' => true,
));
echo $form->beginModalWrap();
echo $form->errorSummary($attachment);

echo $form->textFieldRow($attachment, 'model');
echo $form->textFieldRow($attachment, 'model_id');
echo $form->textFieldRow($attachment, 'filename');
echo $form->textFieldRow($attachment, 'extension');
echo $form->textFieldRow($attachment, 'filetype');
echo $form->textFieldRow($attachment, 'filesize');
echo $form->textFieldRow($attachment, 'notes');
echo $form->textFieldRow($attachment, 'sort_order');
echo $form->textFieldRow($attachment, 'created');
echo $form->textFieldRow($attachment, 'deleted');

echo $form->endModalWrap();
echo '<div class="' . $form->getSubmitRowClass() . '">';
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'icon' => 'ok white',
    'label' => $attachment->isNewRecord ? Yii::t('dressing', 'Create') : Yii::t('dressing', 'Save'),
    'htmlOptions' => array('class' => 'pull-right'),
));
echo '</div>';
$this->endWidget();

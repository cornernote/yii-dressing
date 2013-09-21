<?php
/**
 * @var string $template
 * @var array|string $to
 * @var array $message
 */
?>
<div class="emailDebug">

    <strong><?php echo Yii::t('dressing', 'Template'); ?>:</strong>

    <div class="emailMessage"><?php echo CHtml::encode($template) ?></div>

    <strong><?php echo Yii::t('dressing', 'To'); ?>:</strong>

    <div class="emailMessage"><?php echo nl2br(trim(CHtml::encode(strtr(print_r($to, true), array(
        "Array\n(" => '',
        ")\n" => '',
        '    [' => '',
        '] => ' => ' :: ',
    ))))); ?></div>

    <strong><?php echo Yii::t('dressing', 'Message Subject'); ?>:</strong>

    <div class="emailMessage"><?php echo CHtml::encode($message['message_subject']) ?></div>

    <strong><?php echo Yii::t('dressing', 'Message HTML'); ?>:</strong>

    <div class="emailMessage"><?php echo $message['message_html']; ?></div>

    <strong><?php echo Yii::t('dressing', 'Message Text'); ?>:</strong>

    <div class="emailMessage">
        <pre><?php echo $message['message_text']; ?></pre>
    </div>

</div>
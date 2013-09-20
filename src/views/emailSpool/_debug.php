<?php
/**
 * @var string $template
 * @var array|string $to
 * @var array $message
 */
?>
<div class="emailDebug">

    <strong><?php echo t('Template'); ?>:</strong>

    <div class="emailMessage"><?php echo CHtml::encode($template) ?></div>

    <strong><?php echo t('To'); ?>:</strong>

    <div class="emailMessage"><?php echo nl2br(trim(CHtml::encode(strtr(print_r($to, true), array(
        "Array\n(" => '',
        ")\n" => '',
        '    [' => '',
        '] => ' => ' :: ',
    ))))); ?></div>

    <strong><?php echo t('Message Subject'); ?>:</strong>

    <div class="emailMessage"><?php echo CHtml::encode($message['message_subject']) ?></div>

    <strong><?php echo t('Message HTML'); ?>:</strong>

    <div class="emailMessage"><?php echo $message['message_html']; ?></div>

    <strong><?php echo t('Message Text'); ?>:</strong>

    <div class="emailMessage">
        <pre><?php echo $message['message_text']; ?></pre>
    </div>

</div>
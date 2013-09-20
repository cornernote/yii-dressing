<?php
/**
 * @var $this WebController
 */
?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
    <div class="row">
        <div class="span3">&nbsp;</div>
        <div class="span6">
            <?php $this->renderPartial('//layouts/_content', array('content' => $content)); ?>
        </div>
        <div class="span3">&nbsp;</div>
    </div>
</div>
<?php $this->endContent(); ?>
<?php
/**
 * @var $this WebController
 * @var $content
 */
if (app()->request->isAjaxRequest) {
    $this->beginContent('//layouts/ajax');
    echo user()->multiFlash();
    echo $content;
    $this->endContent();
}
else {
    $this->beginContent('//layouts/main');
    $this->renderPartial('//layouts/_content', array('content' => $content));
    $this->endContent();
}

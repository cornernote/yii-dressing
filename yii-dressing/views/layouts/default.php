<?php
/**
 * @var $this YdWebController
 * @var $content
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-skeleton
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

if (app()->request->isAjaxRequest) {
    $this->beginContent('/layouts/ajax');
    echo user()->multiFlash();
    echo $content;
    $this->endContent();
}
else {
    $this->beginContent('/layouts/main');
    $this->renderPartial('/layouts/_content', array('content' => $content));
    $this->endContent();
}

<?php
/**
 * Default layout
 *
 * This layout will load a layout based on the type of request.
 * - ajax requests will load ajax.php
 * - all other requests will load _content.php wrapped in main.php
 *
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
    $this->beginContent('dressing.views.layouts.ajax');
    echo user()->multiFlash();
    echo $content;
    $this->endContent();
}
else {
    $this->beginContent('dressing.views.layouts.main');
    $this->renderPartial('dressing.views.layouts._content', array('content' => $content));
    $this->endContent();
}

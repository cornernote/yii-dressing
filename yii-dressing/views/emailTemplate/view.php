<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate YdEmailTemplate
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
$this->pageTitle = $emailTemplate->getName();

$this->renderPartial('/emailTemplate/_menu', array(
    'emailTemplate' => $emailTemplate,
));

$attributes = array();
$attributes[] = 'name';
$attributes[] = 'description';
$attributes[] = 'message_subject';
$attributes[] = array('name' => 'message_html', 'type' => 'raw');
$attributes[] = 'message_text';
$attributes[] = 'created';

$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $emailTemplate,
    'attributes' => $attributes,
));

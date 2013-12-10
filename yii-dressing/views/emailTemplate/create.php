<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate YdEmailTemplate
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

$this->pageTitle = $this->getName() . ' ' . Yii::t('dressing', 'Create');

$this->renderPartial('/emailTemplate/_menu', array(
    'emailTemplate' => $emailTemplate,
));
$this->renderPartial('/emailTemplate/_form', array(
    'emailTemplate' => $emailTemplate,
));

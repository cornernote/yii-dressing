<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool YdEmailSpool
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

$this->pageTitle = $emailSpool->getName();

$this->renderPartial('/emailSpool/_menu', array(
    'emailSpool' => $emailSpool,
));
$this->renderPartial('/auditTrail/_log', array(
    'model' => $emailSpool,
));

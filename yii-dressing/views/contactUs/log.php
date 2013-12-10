<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

$this->pageTitle = $contactUs->getName();

$this->renderPartial('/contactUs/_menu', array(
    'contactUs' => $contactUs,
));
$this->renderPartial('/contactUs/_log', array(
    'model' => $contactUs,
));

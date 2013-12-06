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

$this->pageTitle = $this->pageHeading = 'Thank You';

$this->breadcrumbs[$this->getName()] = array('/contactUs/contact');
$this->breadcrumbs[] = Yii::t('dressing', 'Thank You');

echo Yii::t('dressing', 'Thank you for your email.');


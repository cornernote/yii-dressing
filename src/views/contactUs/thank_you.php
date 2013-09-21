<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 */

$this->pageTitle = $this->pageHeading = 'Thank You';

$this->breadcrumbs[$this->getName()] = array('/contactUs/contact');
$this->breadcrumbs[] = Yii::t('dressing', 'Thank You');

echo Yii::t('dressing', 'Thank you for your email.');


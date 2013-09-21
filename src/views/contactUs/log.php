<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 */

$this->pageTitle = $this->pageHeading = $contactUs->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'Log');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[$this->getName() . ' ' . Yii::t('dressing', 'List')] = Yii::app()->user->getState('index.contactUs', array('/contactUs/index'));
$this->breadcrumbs[$contactUs->getName()] = $contactUs->getUrl();
$this->breadcrumbs[] = Yii::t('dressing', 'Log');

$this->renderPartial('dressing.views.contactUs._menu', array(
    'contactUs' => $contactUs,
));
$this->renderPartial('dressing.views.contactUs._log', array(
    'model' => $contactUs,
));

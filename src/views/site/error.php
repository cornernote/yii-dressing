<?php
/**
 * @var $this SiteController
 */

$this->pageTitle = t('Error');
//$this->pageHeading = t('Error');
//$this->breadcrumbs = array(
//    t('Error'),
//);

$this->beginWidget('bootstrap.widgets.TbHeroUnit', array(
    'heading' => t('Error'),
));
echo '<p>' . CHtml::encode($message) . '</p>';
$this->endWidget();

<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 */

$this->pageTitle = $this->pageHeading = $contactUs->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'View');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[$this->getName() . ' ' . Yii::t('dressing', 'List')] = Yii::app()->user->getState('index.contactUs', array('/contactUs/index'));
$this->breadcrumbs[] = $contactUs->getName();

$this->renderPartial('dressing.views.contactUs._menu', array(
    'contactUs' => $contactUs,
));

$attributes = array();
$attributes[] = array(
    'name' => 'id',
);
$attributes[] = array(
    'name' => 'name',
);
$attributes[] = array(
    'name' => 'email',
);
$attributes[] = array(
    'name' => 'phone',
);
$attributes[] = array(
    'name' => 'company',
);
$attributes[] = array(
    'name' => 'subject',
);
$attributes[] = array(
    'name' => 'message',
    'type' => 'raw',
);
$attributes[] = array(
    'name' => 'ip_address',
);
$attributes[] = array(
    'name' => 'created',
);

$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $contactUs,
    'attributes' => $attributes,
));

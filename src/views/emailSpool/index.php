<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool YdEmailSpool
 */
Yii::app()->user->setState('index.emailSpool', Yii::app()->request->requestUri);
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Email Spools');

$this->renderPartial('dressing.views.emailSpool._menu');

echo '<div class="spacer">';
if (Yii::app()->user->getState('index.emailSpool') != Yii::app()->createUrl('/emailSpool/index')) {
    //echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('dressing', 'Reset Filters'),
        'url' => array('/emailSpool/index'),
    ));
}
echo '</div>';

// grid
$this->renderPartial('dressing.views.emailSpool._grid', array('emailSpool' => $emailSpool));

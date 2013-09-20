<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool EmailSpool
 */
user()->setState('index.emailSpool', ru());
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('List');
$this->breadcrumbs = array($this->getName() . ' ' . t('List'));
$this->renderPartial('_menu');

echo '<div class="spacer">';
if (user()->getState('index.emailSpool') != url('/emailSpool/index')) {
    //echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => t('Reset Filters'),
        'url' => array('/emailSpool/index'),
    ));
}
echo '</div>';

// grid
$this->renderPartial('/emailSpool/_grid', array('emailSpool' => $emailSpool));

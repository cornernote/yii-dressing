<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool YdEmailSpool
 */
user()->setState('index.emailSpool', ru());
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('List');
$this->breadcrumbs = array($this->getName() . ' ' . t('List'));
$this->renderPartial('dressing.views.emailSpool._menu');

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
$this->renderPartial('dressing.views.emailSpool._grid', array('emailSpool' => $emailSpool));

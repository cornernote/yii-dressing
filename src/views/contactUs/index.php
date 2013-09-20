<?php
/**
 * @var $this ContactUsController
 * @var $contactUs ContactUs
 */

user()->setState('index.contactUs', ru());
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('List');
$this->breadcrumbs = array($this->getName() . ' ' . t('List'));

$this->renderPartial('_menu');

echo '<div class="spacer">';

$this->widget('bootstrap.widgets.TbButton', array(
    'label' => t('Search'),
    'htmlOptions' => array('class' => 'search-button'),
    'toggle' => true,
));
if (user()->getState('index.contactUs') != url('/contactUs/index')) {
    echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => t('Reset Filters'),
        'url' => array('/contactUs/index'),
    ));
}
echo '</div>';

// search
$this->renderPartial('/contactUs/_search', array(
    'contactUs' => $contactUs,
));

// grid
$this->renderPartial('/contactUs/_grid', array(
    'contactUs' => $contactUs,
));

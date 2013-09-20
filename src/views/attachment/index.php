<?php
/**
 * @var $this AttachmentController
 * @var $attachment Attachment
 */

user()->setState('index.attachment', ru());
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('List');
$this->breadcrumbs = array($this->getName() . ' ' . t('List'));

$this->menu = Menu::getItemsFromMenu('Main');

echo '<div class="spacer">';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => t('Create') . ' ' . $this->getName(),
    'url' => array('/attachment/create'),
    'type' => 'primary',
    'htmlOptions' => array('data-toggle' => 'modal-remote'),
));
echo ' ';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => t('Search'),
    'htmlOptions' => array('class' => 'search-button'),
    'toggle' => true,
));
if (user()->getState('index.attachment') != url('/attachment/index')) {
    echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => t('Reset Filters'),
        'url' => array('/attachment/index'),
    ));
}
echo '</div>';

// search
$this->renderPartial('/attachment/_search', array(
    'attachment' => $attachment,
));

// grid
$this->renderPartial('/attachment/_grid', array(
    'attachment' => $attachment,
));

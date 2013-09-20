<?php
/**
 * @var $this NoteController
 * @var $note Note
 */

user()->setState('index.note', ru());
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('List');
$this->breadcrumbs = array($this->getName() . ' ' . t('List'));

$this->menu = Menu::getItemsFromMenu('System');

echo '<div class="spacer">';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => t('Create') . ' ' . $this->getName(),
    'url' => array('/note/create'),
    'type' => 'primary',
    'htmlOptions' => array('data-toggle' => 'modal-remote'),
));
echo ' ';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => t('Search'),
    'htmlOptions' => array('class' => 'search-button'),
    'toggle' => true,
));
if (user()->getState('index.note') != url('/note/index')) {
    echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => t('Reset Filters'),
        'url' => array('/note/index'),
    ));
}
echo '</div>';

// search
$this->renderPartial('/note/_search', array(
    'note' => $note,
));

// grid
$this->renderPartial('/note/_grid', array(
    'note' => $note,
));

<?php
/**
 * @var $this UserController
 * @var $user YdUser
 */
user()->setState('index.user', ru());
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . t('List');
$this->breadcrumbs = array($this->getName() . ' ' . t('List'));

$this->renderPartial('dressing.views.user._menu', array(
    'user' => $user,
));

echo '<div class="spacer">';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => t('Create User'),
    'url' => array('/user/create'),
    'type' => 'primary',
    'htmlOptions' => array('data-toggle' => 'modal-remote'),
));
echo ' ';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => t('Search'),
    'htmlOptions' => array('class' => 'user-grid-search'),
    'toggle' => true,
));
if (user()->getState('index.user') != url('/user/index')) {
    echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => t('Reset Filters'),
        'url' => array('/user/index'),
    ));
}
echo '</div>';

// search
$this->renderPartial('dressing.views.user._search', array(
    'user' => $user,
));

// grid
$this->renderPartial('dressing.views.user._grid', array(
    'user' => $user,
));

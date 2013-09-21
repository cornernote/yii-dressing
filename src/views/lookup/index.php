<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 */

user()->setState('index.lookup', Yii::app()->request->requestUri);
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Lookups')] = Yii::app()->user->getState('index.lookup', array('/lookup/index'));
$this->breadcrumbs[] = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->renderPartial('dressing.views.lookup._menu', array(
    'lookup' => $lookup,
));


echo '<div class="spacer">';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Create') . ' ' . $this->getName(),
    'url' => array('/lookup/create'),
    'type' => 'primary',
    'htmlOptions' => array('data-toggle' => 'modal-remote'),
));
echo ' ';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Search'),
    'htmlOptions' => array('class' => 'search-button'),
    'toggle' => true,
));
if (Yii::app()->user->getState('index.lookup') != Yii::app()->createUrl('/lookup/index')) {
    echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('dressing', 'Reset Filters'),
        'url' => array('/lookup/index'),
    ));
}
echo '</div>';

// search
$this->renderPartial('dressing.views.lookup._search', array(
    'lookup' => $lookup,
));

// grid
$this->renderPartial('dressing.views.lookup._grid', array(
    'lookup' => $lookup,
));

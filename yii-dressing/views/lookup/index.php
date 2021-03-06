<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

Yii::app()->user->setState('index.lookup', Yii::app()->request->requestUri);
$this->pageTitle = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->renderPartial('/lookup/_menu', array(
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
$this->renderPartial('/lookup/_search', array(
    'lookup' => $lookup,
));

// grid
$this->renderPartial('/lookup/_grid', array(
    'lookup' => $lookup,
));

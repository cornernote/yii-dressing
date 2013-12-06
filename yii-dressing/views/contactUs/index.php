<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

Yii::app()->user->setState('index.contactUs', Yii::app()->request->requestUri);
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[] = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->renderPartial('/contactUs/_menu');

echo '<div class="spacer">';

$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Search'),
    'htmlOptions' => array('class' => 'contactUs-grid-search'),
    'toggle' => true,
));
if (Yii::app()->user->getState('index.contactUs') != Yii::app()->createUrl('/contactUs/index')) {
    echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('dressing', 'Reset Filters'),
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

<?php
/**
 * @var $this RoleController
 * @var $role YdRole
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

Yii::app()->user->setState('index.role', Yii::app()->request->requestUri);
$this->pageTitle = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->renderPartial('/role/_menu');

echo '<div class="spacer">';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Create') . ' ' . $this->getName(),
    'url' => array('/role/create'),
    'type' => 'primary',
    'htmlOptions' => array('data-toggle' => 'modal-remote'),
));
echo ' ';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Search'),
    'htmlOptions' => array('class' => 'role-grid-search'),
    'toggle' => true,
));
if (Yii::app()->user->getState('index.role') != Yii::app()->createUrl('/role/index')) {
    echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('dressing', 'Reset Filters'),
        'url' => array('/role/index'),
    ));
}
echo '</div>';

// search
$this->renderPartial('/role/_search', array(
    'role' => $role,
));

// grid
$this->renderPartial('/role/_grid', array(
    'role' => $role,
));

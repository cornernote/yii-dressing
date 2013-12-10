<?php
/**
 * @var $this UserController
 * @var $user YdUser
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
Yii::app()->user->setState('index.user', Yii::app()->request->requestUri);
$this->pageTitle = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->renderPartial('/user/_menu', array(
    'user' => $user,
));

echo '<div class="spacer">';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Create User'),
    'url' => array('/user/create'),
    'type' => 'primary',
    'htmlOptions' => array('data-toggle' => 'modal-remote'),
));
echo ' ';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Search'),
    'htmlOptions' => array('class' => 'user-grid-search'),
    'toggle' => true,
));
if (Yii::app()->user->getState('index.user') != Yii::app()->createUrl('/user/index')) {
    echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('dressing', 'Reset Filters'),
        'url' => array('/user/index'),
    ));
}
echo '</div>';

// search
$this->renderPartial('/user/_search', array(
    'user' => $user,
));

// grid
$this->renderPartial('/user/_grid', array(
    'user' => $user,
));

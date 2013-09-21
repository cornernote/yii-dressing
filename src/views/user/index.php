<?php
/**
 * @var $this UserController
 * @var $user YdUser
 */
Yii::app()->user->setState('index.user', Yii::app()->request->requestUri);
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Users');

$this->renderPartial('dressing.views.user._menu', array(
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
$this->renderPartial('dressing.views.user._search', array(
    'user' => $user,
));

// grid
$this->renderPartial('dressing.views.user._grid', array(
    'user' => $user,
));

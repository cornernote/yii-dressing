<?php
/**
 * @var $this UserController
 * @var $user YdUser
 */
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'Create');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Users')] = Yii::app()->user->getState('index.user', array('/user/index'));
$this->breadcrumbs[] = Yii::t('dressing', 'Create');

$this->renderPartial('dressing.views.user._menu', array(
    'user' => $user,
));
$this->renderPartial('dressing.views.user._form', array(
    'user' => $user,
));
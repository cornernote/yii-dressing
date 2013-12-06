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
$this->pageTitle = $this->pageHeading = $user->getName() . ' - ' . $this->getName() . ' ' . Yii::t('dressing', 'Log');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[Yii::t('dressing', 'Users')] = Yii::app()->user->getState('index.user', array('/user/index'));
$this->breadcrumbs[$user->getName()] = $user->getLink();
$this->breadcrumbs[] = Yii::t('dressing', 'Log');

$this->renderPartial('/user/_menu', array(
    'user' => $user,
));
$this->renderPartial('/auditTrail/_log', array(
    'model' => $user,
));
<?php
/**
 * @var $this UserController
 * @var $user YdUser
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
$this->pageTitle = $this->getName() . ' ' . Yii::t('dressing', 'Create');

$this->renderPartial('/user/_menu', array(
    'user' => $user,
));
$this->renderPartial('/user/_form', array(
    'user' => $user,
));
<?php
/**
 * @var $this YdAccountController
 * @var $user YdUser
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

$this->pageTitle = Yii::t('dressing', 'My Account');

$this->menu = YdSiteMenu::getItemsFromMenu('User');

$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $user,
    'attributes' => array(
        'username',
        'name',
        'email',
        'phone',
    ),
));
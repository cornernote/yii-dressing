<?php
/**
 * @var $this YdAccountController
 * @var $user YdUser
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

$this->pageTitle = Yii::t('dressing', 'My Account');

$this->menu = SiteMenu::getItemsFromMenu(SiteMenu::MENU_USER);

$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $user,
    'attributes' => array(
        'username',
        'name',
        'email',
        'phone',
    ),
));
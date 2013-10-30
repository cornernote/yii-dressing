<?php
/**
 * @var $this AccountController
 * @var $user YdUser
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'My Account');

$this->breadcrumbs[] = Yii::t('dressing', 'My Account');

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
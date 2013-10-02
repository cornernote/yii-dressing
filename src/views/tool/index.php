<?php
/**
 * @var $this UserController
 * @var $user YdUser
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Tools');

$this->breadcrumbs[] = Yii::t('dressing', 'Tools');

$this->menu = YdMenu::getItemsFromMenu('User');

$items = YdMenu::getItemsFromMenu('Admin');
foreach ($items as $item) {
    echo '<h2>' . $item['label'] . '</h2>';
    $this->widget('bootstrap.widgets.TbMenu', array(
        'type' => 'pills',
        'items' => $item['items'],
    ));
}

<?php
/**
 * @var $this YdWebController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-skeleton
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
$this->pageTitle = Yii::t('dressing', 'Documentation');

// menu
$this->menu = YdSiteMenu::getItemsFromMenu('Help');

// breadcrumbs
$this->addBreadcrumb(Yii::t('dressing', 'Help'), array('/site/page', 'view' => 'help'));

echo '<h2>' . Yii::t('dressing', 'Vendor Documentation') . '</h2>';
$this->widget('bootstrap.widgets.TbMenu', array(
    'type' => 'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false,
    'items' => array(
        array('label' => Yii::t('dressing', 'Yii'), 'url' => 'http://www.yiiframework.com/doc/'),
        array('label' => Yii::t('dressing', 'YiiExt'), 'url' => 'http://yiiext.github.io/'),
        array('label' => Yii::t('dressing', 'Yii Booster'), 'url' => 'http://yiibooster.clevertech.biz/'),
        array('label' => Yii::t('dressing', 'Yii Bootstrap'), 'url' => 'http://www.cniska.net/yii-bootstrap'),
        array('label' => Yii::t('dressing', 'Bootstrap'), 'url' => 'http://twitter.github.io/bootstrap/'),
        array('label' => Yii::t('dressing', 'jQuery'), 'url' => 'http://api.jquery.com/'),
        array('label' => Yii::t('dressing', 'Swift Mailer'), 'url' => 'http://swiftmailer.org/docs/introduction.html'),
        array('label' => Yii::t('dressing', 'Mustache PHP'), 'url' => 'https://github.com/bobthecow/mustache.php'),
        array('label' => Yii::t('dressing', 'Kint'), 'url' => 'http://raveren.github.io/kint/'),
        array('label' => Yii::t('dressing', 'Highcharts'), 'url' => 'http://api.highcharts.com/highcharts'),
    ),
));


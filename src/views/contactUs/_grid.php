<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

$columns = array();
$columns[] = array(
    'name' => 'id',
    'class' => 'dressing.widgets.YdDropdownColumn',
);
$columns[] = array(
    'name' => 'name',
);
$columns[] = array(
    'name' => 'email',
);
$columns[] = array(
    'name' => 'phone',
);
$columns[] = array(
    'name' => 'company',
);
$columns[] = array(
    'name' => 'subject',
);
//$columns[] = array(
//    'name' => 'message',
//);
$columns[] = array(
    'name' => 'ip_address',
);
$columns[] = array(
    'name' => 'created',
);

// multi actions
$multiActions = array();
$multiActions[] = array(
    'name' => Yii::t('dressing', 'Delete'),
    'url' => Yii::app()->createUrl('/contactUs/delete'),
);

// grid
$this->widget('dressing.widgets.YdGridView', array(
    'id' => 'contactUs-grid',
    'dataProvider' => $contactUs->search(),
    'filter' => $contactUs,
    'columns' => $columns,
    'multiActions' => $multiActions,
));

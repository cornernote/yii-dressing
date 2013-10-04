<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
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
    'name' => 'type',
);
$columns[] = array(
    'name' => 'position',
);
$columns[] = array(
    'name' => 'created',
);
$columns[] = array(
    'name' => 'deleted',
);

// multi actions
$multiActions = array();
$multiActions[] = array(
    'name' => Yii::t('dressing', 'Delete'),
    'url' => Yii::app()->createUrl('/lookup/delete'),
);

// grid
$this->widget('dressing.widgets.YdGridView', array(
    'id' => 'lookup-grid',
    'dataProvider' => $lookup->search(),
    'filter' => $lookup,
    'columns' => $columns,
    'multiActions' => $multiActions,
));

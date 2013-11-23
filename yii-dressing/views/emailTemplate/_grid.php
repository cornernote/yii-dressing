<?php
/**
 * @var $this EmailTemplateController
 * @var $emailTemplate YdEmailTemplate
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
    'value' => '$data->getIdString()',
);
$columns[] = array(
    'name' => 'name',
);
$columns[] = array(
    'name' => 'message_subject',
);

// grid
$this->widget('dressing.widgets.YdGridView', array(
    'id' => 'emailTemplate-grid',
    'dataProvider' => $emailTemplate->search(),
    'filter' => $emailTemplate,
    'columns' => $columns,
));


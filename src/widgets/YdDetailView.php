<?php
Yii::import('bootstrap.widgets.TbDetailView');
/**
 * Class YdDetailView
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.widgets
 */
class YdDetailView extends TbDetailView
{
    /**
     * @var array
     */
    public $type = array('striped', 'condensed', 'bordered');
}
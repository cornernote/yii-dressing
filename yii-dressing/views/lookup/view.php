<?php
/**
 * @var $this LookupController
 * @var $lookup YdLookup
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

$this->pageTitle = $lookup->getName();

$this->renderPartial('/lookup/_menu', array(
    'lookup' => $lookup,
));

$attributes = array();
$attributes[] = 'id';
$attributes[] = 'name';
$attributes[] = 'type';
$attributes[] = 'position';
$attributes[] = 'created';
$attributes[] = 'deleted';

$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $lookup,
    'attributes' => $attributes,
));

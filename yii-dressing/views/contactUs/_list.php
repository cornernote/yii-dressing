<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

// list
$this->widget('dressing.widgets.YdListView', array(
    'id' => 'contactUs-list',
    'dataProvider' => $contactUs->search(),
    'itemView' => '/contactUs/_list_view',
));

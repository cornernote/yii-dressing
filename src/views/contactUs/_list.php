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

// list
$this->widget('dressing.widgets.YdListView', array(
    'id' => 'contactUs-list',
    'dataProvider' => $contactUs->search(),
    'itemView' => 'dressing.views.contactUs._list_view',
));

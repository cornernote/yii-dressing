<?php
/**
 * @var $this YdWebController
 * @var $color string
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

$color = isset($color) ? $color : (YII_DEBUG ? 'inherit' : 'transparent');

echo '<span class="small audit-footer" style="color: ' . $color . ';">';
if (Yii::app()->getComponent('auditTracker', false) && $audit = Yii::app()->auditTracker->audit) {
    echo '<!-- audit start -->audit-' . $audit->id . '<!-- audit end -->'; // html comment is used for extracting audit_id
    echo ' | ';
}
echo number_format(microtime(true) - YII_BEGIN_TIME, 2) . 's';
echo ' | ';
echo round(memory_get_peak_usage() / 1024 / 1024, 1) . 'm';
echo ' | ';
echo date('Y-m-d H:i:s');
echo '</span>';

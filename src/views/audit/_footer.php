<?php
/**
 * @var $this YdWebController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

$audit = YdAudit::findCurrent();
if (!$audit) return;

$color = isset($color) ? $color : (YII_DEBUG ? 'inherit' : 'transparent');
echo '<span class="small audit-id" style="color: ' . $color . ';">';
echo '<!-- audit start -->audit-' . $audit->id . '<!-- audit end -->'; // html comment is used for extracting audit_id
echo ' | ';
echo number_format(microtime(true) - $audit->start_time, 2) . 'sec';
echo ' | ';
echo round(memory_get_peak_usage() / 1024 / 1024, 2) . 'mb';
echo '</span>';
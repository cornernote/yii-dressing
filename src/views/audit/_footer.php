<?php
$audit = Audit::findCurrent();
if (!$audit) return;

$color = isset($color) ? $color : (YII_DEBUG ? 'inherit' : 'transparent');
echo '<span class="small audit-id" style="color: ' . $color . ';">';
echo '<!-- audit start -->audit-' . $audit->id . '<!-- audit end -->'; // html comment is used for extracting audit_id
echo ' | ';
echo number_format(microtime(true) - $audit->start_time, 2) . 'sec';
echo ' | ';
echo round(memory_get_peak_usage() / 1024 / 1024, 2) . 'mb';
echo '</span>';
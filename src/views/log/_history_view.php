<?php
echo '<tr class="even">';

echo '<td>';
echo nl2br($data->message);
echo '</td>';

echo '<td>';
echo $data->user ? $data->user->username : t('unknown');
echo '</td>';

echo '<td>';
echo Time::agoIcon($data->created, Setting::item('dateTimeFormat'));
echo '</td>';

echo '</tr>';
?>
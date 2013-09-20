<?php
echo '<tr>';

echo '<td>';
echo isset($data->old_value) ? $data->old_value : '&nbsp;';
echo isset($data->old_value) && isset($data->new_value) ? ' &gt; ' : '';
echo isset($data->new_value) ? $data->new_value : '&nbsp;';
echo '</td>';

echo '<td>';
echo Time::ago($data->created);
echo '</td>';

echo '<td>';
echo '<small>' . $data->created . '</small>';
echo '</td>';

echo '<td>';
if (user()->checkAccess('admin')) {
    echo ($data->user_id && is_numeric($data->user_id) ? User::model()->findByPk($data->user_id)->getLink() : $data->user_id);
}
else {
    echo ($data->user_id && is_numeric($data->user_id) ? User::model()->findByPk($data->user_id)->name : $data->user_id);
}
echo '</td>';

if (user()->checkAccess('admin')) {
    echo '<td>';
    echo $data->audit ? $data->audit->getLink() : '';
    echo '</td>';
}

echo '</tr>';
?>
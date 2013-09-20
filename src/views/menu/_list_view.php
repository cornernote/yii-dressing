<?php
/**
 * @var $this MenuController
 * @var $menu Menu
 */

echo '<div class="view">';

echo '<b>'.CHtml::encode($data->getAttributeLabel('id')).':</b>';
echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)).'<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('parent_id')) . ':</b>';
echo CHtml::encode($data->parent_id) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('label')) . ':</b>';
echo CHtml::encode($data->label) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('icon')) . ':</b>';
echo CHtml::encode($data->icon) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('url')) . ':</b>';
echo CHtml::encode($data->url) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('url_params')) . ':</b>';
echo CHtml::encode($data->url_params) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('target')) . ':</b>';
echo CHtml::encode($data->target) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('access_role')) . ':</b>';
echo CHtml::encode($data->access_role) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('created')) . ':</b>';
echo CHtml::encode($data->created) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('deleted')) . ':</b>';
echo CHtml::encode($data->deleted) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('sort_order')) . ':</b>';
echo CHtml::encode($data->sort_order) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('enabled')) . ':</b>';
echo CHtml::encode($data->enabled) . '<br />';

echo '</div>';

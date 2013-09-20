<?php
/**
 * @var $this LookupController
 * @var $lookup Lookup
 */

echo '<div class="view">';

echo '<b>'.CHtml::encode($data->getAttributeLabel('id')).':</b>';
echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)).'<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('name')) . ':</b>';
echo CHtml::encode($data->name) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('type')) . ':</b>';
echo CHtml::encode($data->type) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('position')) . ':</b>';
echo CHtml::encode($data->position) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('created')) . ':</b>';
echo CHtml::encode($data->created) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('deleted')) . ':</b>';
echo CHtml::encode($data->deleted) . '<br />';

echo '</div>';

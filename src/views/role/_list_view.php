<?php
/**
 * @var $this RoleController
 * @var $role YdRole
 */

echo '<div class="view">';

echo '<b>' . CHtml::encode($data->getAttributeLabel('id')) . ':</b>';
echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('name')) . ':</b>';
echo CHtml::encode($data->name) . '<br />';

echo '</div>';

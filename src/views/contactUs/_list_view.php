<?php
/**
 * @var $this ContactUsController
 * @var $contactUs YdContactUs
 */

echo '<div class="view">';

echo '<b>'.CHtml::encode($data->getAttributeLabel('id')).':</b>';
echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)).'<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('name')) . ':</b>';
echo CHtml::encode($data->name) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('email')) . ':</b>';
echo CHtml::encode($data->email) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('phone')) . ':</b>';
echo CHtml::encode($data->phone) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('company')) . ':</b>';
echo CHtml::encode($data->company) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('subject')) . ':</b>';
echo CHtml::encode($data->subject) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('message')) . ':</b>';
echo CHtml::encode($data->message) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('ip_address')) . ':</b>';
echo CHtml::encode($data->ip_address) . '<br />';

echo '<b>' . CHtml::encode($data->getAttributeLabel('created')) . ':</b>';
echo CHtml::encode($data->created) . '<br />';

echo '</div>';

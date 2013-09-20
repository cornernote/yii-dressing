<?php
$criteria = new CDbCriteria();
$criteria->condition = 'model=:model AND model_id=:model_id';
$criteria->params = array(
    ':model' => $model,
    ':model_id' => $model_id,
);
$dataProvider = new CActiveDataProvider('Log', array(
    'criteria' => $criteria,
    'sort' => array(
        'defaultOrder' => 'created DESC, id DESC',
    ),
));

echo '<div class="grid-view">';
$this->widget('widgets.ListView', array(
    'id' => "log-list-$model-$model_id",
    'dataProvider' => $dataProvider,
    'itemView' => '/log/_history_view',
    'itemsTagName' => 'table',
    'itemsCssClass' => 'items',
));
echo '</div>';
?>
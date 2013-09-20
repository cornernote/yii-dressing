<?php
$criteria = new CDbCriteria();
$criteria->condition = 'model=:model AND model_id=:model_id AND field=:field';
$criteria->params = array(
    ':model' => $model,
    ':model_id' => $model_id,
    ':field' => $field,
);
$dataProvider = new CActiveDataProvider('AuditTrail', array(
    'criteria' => $criteria,
    'sort' => array(
        'defaultOrder' => 'created DESC, id DESC',
    ),
));

echo '<div class="grid-view">';
$this->widget('widgets.ListView', array(
    'id' => "audit-list-$model-$model_id-$field",
    'dataProvider' => $dataProvider,
    'itemView' => '/auditTrail/_field_view',
    'itemsTagName' => 'table',
    'itemsCssClass' => 'table table-condensed table-striped',
));
echo '</div>';
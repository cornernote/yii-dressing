<?php
/**
 * @var $this YdAuditTrailController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

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
$this->widget('dressing.widgets.YdListView', array(
    'id' => "audit-list-$model-$model_id-$field",
    'dataProvider' => $dataProvider,
    'itemView' => '/auditTrail/_field_view',
    'itemsTagName' => 'table',
    'itemsCssClass' => 'table table-condensed table-striped',
));
echo '</div>';
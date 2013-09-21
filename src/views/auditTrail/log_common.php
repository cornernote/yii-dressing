<?php
/**
 * @var $this AuditTrailController
 */
?>
<fieldset>
    <legend><?php echo Yii::t('dressing', 'Time Stamps') ?></legend>
    <?php
    $this->widget('dressing.widgets.YdDetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                'name' => 'created',
                'value' => User::model()->findUsername($model->created_by) . ' at ' . date(YdSetting::item('dateTimeFormat'), strtotime($model->created)) . ' (' . Time::ago($model->created) . ')',
                'type' => 'raw',
            ),
            array(
                'name' => 'modified',
                'value' => User::model()->findUsername($model->modified_by) . ' at ' . date(YdSetting::item('dateTimeFormat'), strtotime($model->modified)) . ' (' . Time::ago($model->modified) . ')',
            ),
            array(
                'name' => 'deleted',
                'value' => $model->deleted ? User::model()->findUsername($model->deleted_by) . ' at ' . date(YdSetting::item('dateTimeFormat'), strtotime($model->deleted)) . ' (' . Time::ago($model->deleted) . ')' : '',
                'visible' => $model->deleted ? true : false,
            ),
        ),
    ));
    ?>
</fieldset>

<fieldset>
    <legend><?php echo Yii::t('dressing', 'Log') ?></legend>
    <?php $this->renderPartial('dressing.views.auditTrail._log', array('model' => $model)); ?>
</fieldset>

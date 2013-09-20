<?
/* @var $model ActiveRecord */
?>
<fieldset>
    <legend><?php echo t('Time Stamps') ?></legend>
    <?php
    $this->widget('widgets.DetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                'name' => 'created',
                'value' => User::model()->findUsername($model->created_by) . ' at ' . date(Setting::item('dateTimeFormat'), strtotime($model->created)) . ' (' . Time::ago($model->created) . ')',
                'type' => 'raw',
            ),
            array(
                'name' => 'modified',
                'value' => User::model()->findUsername($model->modified_by) . ' at ' . date(Setting::item('dateTimeFormat'), strtotime($model->modified)) . ' (' . Time::ago($model->modified) . ')',
            ),
            array(
                'name' => 'deleted',
                'value' => $model->deleted ? User::model()->findUsername($model->deleted_by) . ' at ' . date(Setting::item('dateTimeFormat'), strtotime($model->deleted)) . ' (' . Time::ago($model->deleted) . ')' : '',
                'visible' => $model->deleted ? true : false,
            ),

            // TODO ask Zain what this is... ?  do we need it ?
            // commented it out for now
            //array(
            //    'label' => 'Audit',
            //    'value' => l(t('Related Audits'),
            //        url('/audit/index', array(
            //            'Audit[model]' => 'team',
            //            'Audit[model_id]' => $model->id,
            //        ))
            //    ),
            //    'type' => 'raw',
            //),
        ),
    ));
    ?>
</fieldset>

<fieldset>
    <legend><?php echo t('Log') ?></legend>
    <?php $this->renderPartial('/auditTrail/_log', array('model' => $model)); ?>
</fieldset>

<?php
/**
 * @var $this AuditTrailController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
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
                'value' => User::model()->findUsername($model->created_by) . ' at ' . date(YdConfig::setting('dateTimeFormat'), strtotime($model->created)) . ' (' . Time::ago($model->created) . ')',
                'type' => 'raw',
            ),
            array(
                'name' => 'modified',
                'value' => User::model()->findUsername($model->modified_by) . ' at ' . date(YdConfig::setting('dateTimeFormat'), strtotime($model->modified)) . ' (' . Time::ago($model->modified) . ')',
            ),
            array(
                'name' => 'deleted',
                'value' => $model->deleted ? User::model()->findUsername($model->deleted_by) . ' at ' . date(YdConfig::setting('dateTimeFormat'), strtotime($model->deleted)) . ' (' . Time::ago($model->deleted) . ')' : '',
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

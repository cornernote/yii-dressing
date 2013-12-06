<?php
/**
 * @var $this YdAuditTrailController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

// time stamps
echo '<fieldset><legend>' . Yii::t('dressing', 'Time Stamps') . '</legend>';
$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'name' => 'created',
            'value' => User::model()->findUsername($model->created_by) . ' at ' . Yii::app()->dateFormatter->formatDateTime($model->created) . ' (' . Yii::app()->dateFormatter->ago($model->created) . ')',
            'type' => 'raw',
        ),
        array(
            'name' => 'modified',
            'value' => User::model()->findUsername($model->modified_by) . ' at ' . Yii::app()->dateFormatter->formatDateTime($model->modified) . ' (' . Yii::app()->dateFormatter->ago($model->modified) . ')',
        ),
        array(
            'name' => 'deleted',
            'value' => $model->deleted ? User::model()->findUsername($model->deleted_by) . ' at ' . Yii::app()->dateFormatter->formatDateTime($model->deleted) . ' (' . Yii::app()->dateFormatter->ago($model->deleted) . ')' : '',
            'visible' => $model->deleted ? true : false,
        ),
    ),
));
echo '</fieldset>';

// audit trails
echo '<fieldset><legend>' . Yii::t('dressing', 'Audit Trails') . '</legend>';
$this->renderPartial('/auditTrail/_log', array('model' => $model));
echo '</fieldset>';
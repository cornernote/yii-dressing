<?php
/**
 * YdAuditBehavior automatically tracks changes to model data.
 *
 * @property YdActiveRecord $owner
 * @property YdActiveRecord $auditModel
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.behaviors
 */
class YdAuditBehavior extends CActiveRecordBehavior
{

    /**
     * Any additional models you want to use to write model and model_id audits to.  If this array is not empty then
     * each field modifed will result in an YdAuditTrail being created for each additionalAuditModels.
     * @var array
     * - modelName => modelIdField
     */
    public $additionalAuditModels = array();

    /**
     * A list of values that will be treated as if they were null.
     * @var array
     */
    public $ignoreValues = array('0', '0.0', '0.00', '0.000', '0.0000', '0.00000', '0.000000', '0000-00-00', '0000-00-00 00:00:00');

    /**
     * A list of fields to be ignored on update and delete
     * @var array
     * - insert: array()
     * - update: array()
     */
    public $ignoreFields = array(
        'insert' => array('modified', 'modified_by', 'deleted', 'deleted_by'),
        'update' => array('created', 'created_by', 'modified'),
    );

    /**
     * The model that will be used to populate model and model_id fields.
     * @var YdActiveRecord
     * @see getAuditModel
     */
    private $_auditModel;

    /**
     * Find changes to the model and save them as YdAuditTrail records
     * Do not call this method directly, it will be called after the model is saved.
     * @param CModelEvent $event
     */
    public function afterSave($event)
    {
        if (!Yii::app()->dressing->audit) {
            parent::afterSave($event);
            return;
        }

        $date = date('Y-m-d H:i:s');
        $newAttributes = $this->owner->attributes;
        $oldAttributes = $this->owner->dbAttributes;
        $auditModels = $this->getAuditModels();
        $auditId = Yii::app()->auditTracker->audit ? Yii::app()->auditTracker->audit->id : 0;
        $auditTrails = array();
        $userId = Yii::app()->user && Yii::app()->user->id ? Yii::app()->user->id : 0;

        // insert
        if ($this->owner->isNewRecord) {
            foreach ($newAttributes as $name => $new) {
                if (in_array($name, $this->ignoreFields['insert'])) continue;

                // prepare the values
                $new = trim($new);
                if (!$new) continue;

                // prepare the logs
                foreach ($auditModels as $auditModel) {
                    if (isset($auditModel['ignoreFields']) && in_array($name, $auditModel['ignoreFields'])) continue;
                    $auditTrails[] = array(
                        'old_value' => '',
                        'new_value' => $new,
                        'action' => 'INSERT',
                        'model' => $auditModel['model'],
                        'model_id' => $auditModel['model_id'],
                        'field' => $auditModel['prefix'] . $name,
                        'created' => $date,
                        'user_id' => $userId,
                        'audit_id' => $auditId,
                    );
                }
            }
        }

        // update
        else {
            // compare old and new
            foreach ($newAttributes as $name => $new) {
                if (in_array($name, $this->ignoreFields['update'])) continue;

                // prepare the values
                $old = !empty($oldAttributes) ? trim($oldAttributes[$name]) : '';
                $new = trim($new);
                if (in_array($old, $this->ignoreValues)) $old = '';
                if (in_array($new, $this->ignoreValues)) $new = '';
                if ($new == $old) continue;

                // prepare the logs
                foreach ($auditModels as $auditModel) {
                    if (isset($auditModel['ignoreFields']) && in_array($name, $auditModel['ignoreFields'])) continue;
                    $auditTrails[] = array(
                        'old_value' => $old,
                        'new_value' => $new,
                        'action' => 'UPDATE',
                        'model' => $auditModel['model'],
                        'model_id' => $auditModel['model_id'],
                        'field' => $auditModel['prefix'] . $name,
                        'created' => $date,
                        'user_id' => $userId,
                        'audit_id' => $auditId,
                    );
                }
            }
        }

        // insert the audit_trail records
        if ($auditTrails) {
            Yii::app()->db->commandBuilder->createMultipleInsertCommand(YdAuditTrail::model()->tableName(), $auditTrails)->execute();
        }

        parent::afterSave($event);
    }

    /**
     * Find changes to the model and save them as YdAuditTrail records.
     * Do not call this method directly, it will be called after the model is deleted.
     * @param CModelEvent $event
     */
    public function afterDelete($event)
    {
        if (!Yii::app()->dressing->audit) {
            parent::afterDelete($event);
            return;
        }

        $date = date('Y-m-d H:i:s');
        $auditModels = $this->getAuditModels();
        $auditId = Yii::app()->auditTracker->audit ? Yii::app()->auditTracker->audit->id : 0;
        $userId = Yii::app()->user && Yii::app()->user->id ? Yii::app()->user->id : 0;
        $auditTrails = array();

        // prepare the logs
        $pk = $this->auditModel->getPrimaryKeyString();
        foreach ($auditModels as $auditModel) {
            $prefix = isset($auditModel['prefix']) ? $auditModel['prefix'] . '.' . $pk : '';
            $auditTrails[] = array(
                'old_value' => '',
                'new_value' => '',
                'action' => 'DELETE',
                'model' => $auditModel['model'],
                'model_id' => $auditModel['model_id'],
                'field' => $prefix . '*',
                'created' => $date,
                'user_id' => $userId,
                'audit_id' => $auditId,
            );
        }

        // insert the audit_trail records
        if ($auditTrails) {
            Yii::app()->db->commandBuilder->createMultipleInsertCommand(YdAuditTrail::model()->tableName(), $auditTrails)->execute();
        }

        parent::afterDelete($event);
    }

    /**
     * Gets the model to be used in the model and model_id fields.
     * If a method exists in the owner called getAuditModel() it must return an YdActiveRecord which will be used.
     * Otherwise the owner model itself will be used.
     * @return YdActiveRecord
     */
    protected function getAuditModel()
    {
        if ($this->_auditModel)
            return $this->_auditModel;
        if (method_exists($this->owner, 'getAuditModel'))
            return $this->auditModel = call_user_func(array($this->owner, 'getAuditModel'));
        return $this->_auditModel = $this->owner;
    }

    /**
     * Gets additional models to be used in the model and model_id fields.
     * @return array
     * @see additionalAuditModels
     */
    protected function getAuditModels()
    {
        $auditModels = array();

        // get log models
        if ($this->auditModel) {
            $auditModels[] = array(
                'model' => get_class($this->auditModel),
                'model_id' => $this->auditModel->getPrimaryKeyString(),
                'prefix' => $this->fieldPrefix(),
            );
        }

        // also log to additionalAuditModels
        foreach ($this->additionalAuditModels as $model => $fk_field) {
            $auditModels[] = array(
                'model' => $model,
                'model_id' => $this->owner->$fk_field,
                'prefix' => get_class($this->owner) . '.',
                'ignoreFields' => array($fk_field),
            );
        }

        return $auditModels;
    }

    /**
     * If the model is not the same as the owner then prefix the field so we know the model.
     * @return string
     */
    protected function fieldPrefix()
    {
        if (get_class($this->owner) != get_class($this->auditModel)) {
            return get_class($this->owner) . '.';
        }
        return '';
    }

}

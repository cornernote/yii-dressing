<?php
/**
 * YdAuditBehavior
 *
 * @property YdActiveRecord $owner
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */
class YdAuditBehavior extends CActiveRecordBehavior
{
    /**
     * @var YdActiveRecord
     */
    public $auditModel;

    /**
     * @var array
     */
    public $additionalAuditModels = array();

    /**
     * @var array
     */
    public $ignoreValues = array('0', '0.0', '0.00', '0.000', '0.0000', '0.00000', '0.000000', '0000-00-00', '0000-00-00 00:00:00');

    /**
     * @var array
     */
    public $ignoreFields = array(
        'insert' => array('modified', 'modified_by', 'deleted', 'deleted_by'),
        'update' => array('created', 'created_by', 'modified'),
    );

    /**
     * @param CModelEvent $event
     */
    public function afterSave($event)
    {
        if (!YdSetting::item('audit')) {
            parent::afterSave($event);
        }

        $date = date('Y-m-d H:i:s');
        $newAttributes = $this->owner->attributes;
        $oldAttributes = $this->owner->dbAttributes;
        $auditModels = $this->getAuditModels();
        $auditId = YdAudit::findCurrentId();
        $auditTrails = array();
        $userId = Yii::app()->user ? Yii::app()->user->id : 0;

        // insert
        if ($this->owner->isNewRecord) {
            foreach ($newAttributes as $name => $new) {
                if (in_array($name, $this->ignoreFields['insert'])) continue;

                // prepare the values
                $new = trim($new);
                if (!$new) continue;

                // write the logs
                foreach ($auditModels as $auditModel) {
                    if (isset($auditModel['ignoreFields']) && in_array($name, $auditModel['ignoreFields'])) continue;
                    //$auditTrail = new YdAuditTrail;
                    //$auditTrail->old_value = '';
                    //$auditTrail->new_value = $new;
                    //$auditTrail->action = 'INSERT';
                    //$auditTrail->model = $auditModel['model'];
                    //$auditTrail->model_id = $auditModel['model_id'];
                    //$auditTrail->field = $auditModel['prefix'] . $name;
                    //$auditTrail->created = $date;
                    //$auditTrail->user_id = Yii::app()->user ? Yii::app()->user->id : 0;
                    //$auditTrail->audit_id = $auditId;
                    //$auditTrail->save(false);
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

                // write the logs
                foreach ($auditModels as $auditModel) {
                    if (isset($auditModel['ignoreFields']) && in_array($name, $auditModel['ignoreFields'])) continue;
                    //$auditTrail = new YdAuditTrail();
                    //$auditTrail->old_value = $old;
                    //$auditTrail->new_value = $new;
                    //$auditTrail->action = 'UPDATE';
                    //$auditTrail->model = $auditModel['model'];
                    //$auditTrail->model_id = $auditModel['model_id'];
                    //$auditTrail->field = $auditModel['prefix'] . $name;
                    //$auditTrail->created = $date;
                    //$auditTrail->user_id = Yii::app()->user ? Yii::app()->user->id : 0;
                    //$auditTrail->audit_id = $auditId;
                    //$auditTrail->save(false);
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
     * @param CModelEvent $event
     */
    public function afterDelete($event)
    {
        if (!YdSetting::item('audit')) {
            parent::afterDelete($event);
        }

        $date = date('Y-m-d H:i:s');
        $auditModels = $this->getAuditModels();
        $auditId = YdAudit::findCurrentId();
        $userId = Yii::app()->user ? Yii::app()->user->id : 0;
        $auditTrails = array();

        // delete
        $pk = $this->auditModel->getPrimaryKeyString();
        foreach ($auditModels as $auditModel) {
            $prefix = isset($auditModel['prefix']) ? $auditModel['prefix'] . '.' . $pk : '';
            //$auditTrail = new YdAuditTrail;
            //$auditTrail->old_value = '';
            //$auditTrail->new_value = '';
            //$auditTrail->action = 'DELETE';
            //$auditTrail->model = $auditModel['model'];
            //$auditTrail->model_id = $auditModel['model_id'];
            //$auditTrail->field = $prefix . '*';
            //$auditTrail->created = $date;
            //$auditTrail->user_id = Yii::app()->user ? Yii::app()->user->id : 0;
            //$auditTrail->audit_id = $auditId;
            //$auditTrail->save(false);
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
     * @return string
     */
    protected function fieldPrefix()
    {
        if (get_class($this->owner) != get_class($this->auditModel)) {
            return get_class($this->owner) . '.';
        }
        return '';
    }

    /**
     * @return array
     */
    protected function getAuditModels()
    {
        if ($this->auditModel === null) {
            if (method_exists($this->owner, 'getAuditModel')) {
                $this->auditModel = call_user_func(array($this->owner, 'getAuditModel'));
            }
            else {
                $this->auditModel = $this->owner;
            }
        }

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

}

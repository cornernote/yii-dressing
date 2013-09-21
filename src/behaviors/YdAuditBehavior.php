<?php
/**
 * YdAuditBehavior
 *
 * @property ActiveRecord $owner
 *
 * @package components.behaviors
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class YdAuditBehavior extends CActiveRecordBehavior
{
    /**
     * @var ActiveRecord
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
        $logModels = $this->getLogModels();
        $auditId = YdAudit::findCurrentId();

        // insert
        if ($this->owner->isNewRecord) {
            foreach ($newAttributes as $name => $new) {
                if (in_array($name, $this->ignoreFields['insert'])) continue;

                // prepare the values
                $new = trim($new);
                if (!$new) continue;

                // write the logs
                foreach ($logModels as $logModel) {
                    if (isset($logModel['ignoreFields']) && in_array($name, $logModel['ignoreFields'])) continue;
                    $log = new YdAuditTrail;
                    $log->old_value = '';
                    $log->new_value = $new;
                    $log->action = 'INSERT';
                    $log->model = $logModel['model'];
                    $log->model_id = $logModel['model_id'];
                    $log->field = $logModel['prefix'] . $name;
                    $log->created = $date;
                    $log->user_id = Yii::app()->user ? Yii::app()->user->id : 0;
                    $log->audit_id = $auditId;
                    $log->save();
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
                foreach ($logModels as $logModel) {
                    if (isset($logModel['ignoreFields']) && in_array($name, $logModel['ignoreFields'])) continue;
                    $log = new YdAuditTrail();
                    $log->old_value = $old;
                    $log->new_value = $new;
                    $log->action = 'UPDATE';
                    $log->model = $logModel['model'];
                    $log->model_id = $logModel['model_id'];
                    $log->field = $logModel['prefix'] . $name;
                    $log->created = $date;
                    $log->user_id = Yii::app()->user ? Yii::app()->user->id : 0;
                    $log->audit_id = $auditId;
                    $log->save();
                }
            }
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
        $logModels = $this->getLogModels();
        $auditId = YdAudit::findCurrentId();

        // delete
        $pk = $this->auditModel->getPrimaryKeyString();
        foreach ($logModels as $logModel) {
            $prefix = isset($logModel['prefix']) ? $logModel['prefix'] . '.' . $pk : '';
            $log = new YdAuditTrail;
            $log->old_value = '';
            $log->new_value = '';
            $log->action = 'DELETE';
            $log->model = $logModel['model'];
            $log->model_id = $logModel['model_id'];
            $log->field = $prefix . '*';
            $log->created = $date;
            $log->user_id = Yii::app()->user ? Yii::app()->user->id : 0;
            $log->audit_id = $auditId;
            $log->save();
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
    protected function getLogModels()
    {
        if ($this->auditModel === null) {
            if (method_exists($this->owner, 'getAuditModel')) {
                $this->auditModel = call_user_func(array($this->owner, 'getAuditModel'));
            }
            else {
                $this->auditModel = $this->owner;
            }
        }

        $logModels = array();

        // get log models
        if ($this->auditModel) {
            $logModels[] = array(
                'model' => get_class($this->auditModel),
                'model_id' => $this->auditModel->getPrimaryKeyString(),
                'prefix' => $this->fieldPrefix(),
            );
        }

        // also log to additionalAuditModels
        foreach ($this->additionalAuditModels as $model => $fk_field) {
            $logModels[] = array(
                'model' => $model,
                'model_id' => $this->owner->$fk_field,
                'prefix' => get_class($this->owner) . '.',
                'ignoreFields' => array($fk_field),
            );
        }

        return $logModels;
    }

}

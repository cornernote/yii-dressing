<?php
Yii::import('dressing.behaviors.EEavBehavior');

/**
 * @package components.behaviors
 * @property ActiveRecord $owner
 * @method ActiveRecord getOwner() getOwner()
 */
class YdEavBehavior extends EEavBehavior
{

    /**
     * @var string
     */
    public $cacheId = 'cache';

    /**
     * @var array
     */
    private $dbAttributes = array();

    /**
     * @access public
     * @param array $attributes key for load.
     * @return CActiveRecord
     */
    public function loadEavAttributes($attributes)
    {
        parent::loadEavAttributes($attributes);
        $this->dbAttributes = $this->attributes->toArray();
        // Return model.
        return $this->getOwner();
    }

    /**
     * @access protected
     * @param  $attribute
     * @param  $value
     * @return CDbCommand
     */
    protected function getSaveEavAttributeCommand($attribute, $value)
    {
        if ($this->getOwner()->asa('AuditBehavior')) {
            $auditId = Audit::findCurrentId();
            try {
                $userid = Yii::app()->user->id;
            } catch (Exception $e) { //If we have no user object, this must be a command line program
                $userid = 0;
            }
            $old = isset($this->dbAttributes[$attribute]) ? $this->dbAttributes[$attribute] : '';
            $new = $value;

            // log in the audit trail
            if ($old != $new) {
                $log = new AuditTrail();
                $log->old_value = $old;
                $log->new_value = $new;
                $log->action = 'EAV SAVE';
                $log->model = get_class($this->owner->getAuditModel());
                $log->model_id = $this->owner->getAuditModel()->getPrimaryKey();
                $log->field = $this->tableName . '.' . $attribute;
                $log->created = date('Y-m-d H:i:s');
                $log->user_id = $userid;
                $log->audit_id = $auditId;
                $log->save();
            }
        }

        // return parent
        return parent::getSaveEavAttributeCommand($attribute, $value);
    }

    /**
     * @access protected
     * @param  $attributes
     * @return CDbCriteria
     */
    protected function getFindByEavAttributesCriteria($attributes)
    {
        $criteria = new CDbCriteria();
        $pk = $this->getModelTableFk();

        $conn = $this->getOwner()->getDbConnection();
        $i = 0;
        foreach ($attributes as $attribute => $values) {
            // If search models with attribute name with specified values.
            if (is_string($attribute)) {
                $attribute = $conn->quoteValue($attribute);
                $joinTableName = "eav_$attribute";
                if (!is_array($values)) $values = array($values);
                foreach ($values as $value) {
                    $value = $conn->quoteValue($value);
                    $criteria->join .= "\nJOIN {$this->tableName} $joinTableName"
                        . "\nON t.{$pk} = $joinTableName.{$this->entityField}"
                        . "\nAND $joinTableName.{$this->attributeField} = $attribute"
                        . "\nAND $joinTableName.{$this->valueField} = $value";
                    $i++;
                }
            }
            // If search models with attribute name with anything values.
            elseif (is_int($attribute)) {
                $joinTableName = "eav_$values";
                $values = $conn->quoteValue($values);
                $criteria->join .= "\nJOIN {$this->tableName} $joinTableName"
                    . "\nON t.{$pk} = $joinTableName.{$this->entityField}"
                    . "\nAND $joinTableName.{$this->attributeField} = $values";
                $i++;
            }
        }
        $criteria->distinct = TRUE;
        $criteria->group .= "t.{$pk}";
        return $criteria;
    }


    /**
     * @access protected
     * @param  $attributes
     * @return CDbCriteria
     */
    protected function getLoadEavAttributesCriteria($attributes = array())
    {
        $criteria = new CDbCriteria;
        $conn = $this->getOwner()->getDbConnection();
        $id = $this->getModelId();
        if (!is_int($id)) {
            $id = $conn->quoteValue($id);
        }
        $criteria->addCondition("{$this->entityField} = $id");
        if (!empty($attributes)) {
            $criteria->addInCondition($this->attributeField, $attributes);
        }
        return $criteria;
    }

}

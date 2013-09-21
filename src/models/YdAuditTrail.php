<?php

/**
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'audit_trail'
 *
 * @method AuditTrail with() with()
 * @method AuditTrail find() find($condition, array $params = array())
 * @method AuditTrail[] findAll() findAll($condition = '', array $params = array())
 * @method AuditTrail findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method AuditTrail[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method AuditTrail findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method AuditTrail[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method AuditTrail findBySql() findBySql($sql, array $params = array())
 * @method AuditTrail[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Properties from relation
 * @property YdUser $user
 * @property YdAudit $audit
 *
 * Properties from table fields
 * @property integer $id
 * @property integer $audit_id
 * @property string $old_value
 * @property string $new_value
 * @property string $action
 * @property string $model
 * @property string $model_id
 * @property string $field
 * @property datetime $created
 * @property integer $user_id
 *
 * --- END GenerateProperties ---
 */
class YdAuditTrail extends YdActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return AuditTrail the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(
                self::BELONGS_TO,
                'YdUser',
                'user_id',
            ),
            'audit' => array(
                self::BELONGS_TO,
                'YdAudit',
                'audit_id',
            ),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            // search fields
            array('id, new_value, old_value, action, model, field, created, user_id, model_id, audit_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('dressing', 'ID'),
            'old_value' => Yii::t('dressing', 'Old Value'),
            'new_value' => Yii::t('dressing', 'New Value'),
            'action' => Yii::t('dressing', 'Action'),
            'model' => Yii::t('dressing', 'Model'),
            'field' => Yii::t('dressing', 'Field'),
            'created' => Yii::t('dressing', 'Created'),
            'user_id' => Yii::t('dressing', 'User'),
            'model_id' => Yii::t('dressing', 'Model'),
            'audit_id' => Yii::t('dressing', 'Audit'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param array $options
     * @return YdActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($options = array())
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('old_value', $this->old_value);
        $criteria->compare('new_value', $this->new_value);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('model', $this->model);
        $criteria->compare('field', $this->field);
        $criteria->compare('created', $this->created);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('model_id', $this->model_id);
        $criteria->compare('audit_id', $this->audit_id);
        $criteria->mergeWith($this->getDbCriteria());

        return new YdActiveDataProvider(get_class($this), CMap::mergeArray(array(
            'criteria' => $criteria,
        ), $options));
    }

    /**
     * @return null|string
     */
    public function getOldValueString()
    {
        return $this->old_value;
    }

    /**
     * @return null|string
     */
    public function getNewValueString()
    {
        return $this->new_value;
    }

}
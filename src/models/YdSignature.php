<?php
/**
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'signature'
 *
 * @method Signature with() with()
 * @method Signature find() find($condition, array $params = array())
 * @method Signature[] findAll() findAll($condition = '', array $params = array())
 * @method Signature findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method Signature[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method Signature findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method Signature[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method Signature findBySql() findBySql($sql, array $params = array())
 * @method Signature[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Methods from behavior SoftDeleteBehavior
 * @method undelete() undelete()
 * @method deleteds() deleteds()
 * @method notdeleteds() notdeleteds()
 *
 * Properties from table fields
 * @property string $id
 * @property string $model
 * @property string $model_id
 * @property string $name
 * @property string $signature
 * @property datetime $created
 * @property datetime $deleted
 *
 * --- END GenerateProperties ---
 */

class YdSignature extends YdActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Signature the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'signature';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        $rules = array();
        $rules[] = array('model, model_id, name, signature, created', 'required');
        $rules[] = array('model, name', 'length', 'max'=>255);
        $rules[] = array('model_id', 'length', 'max'=>64);
        $rules[] = array('deleted', 'safe');
        return $rules;
    }

    /**
     * @return array containing model behaviors
     */
    public function behaviors()
    {
        return array(
            'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
            'TimestampBehavior' => 'dressing.behaviors.YdTimestampBehavior',
            'SoftDeleteBehavior' => 'dressing.behaviors.YdSoftDeleteBehavior',
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => t('ID'),
            'model' => t('Model'),
            'model_id' => t('Model'),
            'name' => t('Name'),
            'signature' => t('Signature'),
            'created' => t('Created'),
            'deleted' => t('Deleted'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param array $options
     * @return YdActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($options = array())
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('model',$this->model,true);
        $criteria->compare('model_id',$this->model_id,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('signature',$this->signature,true);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('deleted',$this->deleted,true);

        return new YdActiveDataProvider($this, CMap::mergeArray(array(
            'criteria' => $criteria,
        ), $options));
    }

    /**
     * Retrieves a list of links to be used in menus.
     * @param bool $extra
     * @return array
     */
    public function getDropdownLinkItems($extra = false)
    {
        $links = array();
        $links[] = array('label' => t('Update'), 'url' => $this->getUrl('update'));
        if ($extra) {
            $more = array();
            $more[] = array('label' => t('Clear Cache'), 'url' => array('/tool/clearCacheModel', 'model' => get_class($this), 'id' => $this->getPrimaryKeyString()));
            $more[] = array('label' => t('View Log'), 'url' => $this->getUrl('log'));
            if (!$this->deleted)
                $more[] = array('label' => t('Delete'), 'url' => $this->getUrl('delete', array('returnUrl' => Yii::app()->returnUrl->getLinkValue(true))), 'linkOptions' => array('data-toggle' => 'modal-remote'));
            else
                $more[] = array('label' => t('Undelete'), 'url' => $this->getUrl('delete', array('task' => 'undelete', 'returnUrl' => Yii::app()->returnUrl->getLinkValue(true))), 'linkOptions' => array('data-toggle' => 'modal-remote'));
            $links[] = array(
                'label' => t('More'),
                'items' => $more,
            );
        }
        return $links;
    }

}


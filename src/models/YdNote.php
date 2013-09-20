<?php
/**
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'note'
 *
 * @method Note with() with()
 * @method Note find() find($condition, array $params = array())
 * @method Note[] findAll() findAll($condition = '', array $params = array())
 * @method Note findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method Note[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method Note findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method Note[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method Note findBySql() findBySql($sql, array $params = array())
 * @method Note[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Methods from behavior SoftDeleteBehavior
 * @method undelete() undelete()
 * @method deleteds() deleteds()
 * @method notdeleteds() notdeleteds()
 *
 * Properties from table fields
 * @property integer $id
 * @property string $notes
 * @property string $model
 * @property integer $model_id
 * @property integer $sort_order
 * @property integer $important
 * @property datetime $created
 * @property datetime $deleted
 *
 * --- END GenerateProperties ---
 */

class YdNote extends ActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Note the static model class
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
        return 'note';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        $rules = array();
        $rules[] = array('notes, model, model_id, sort_order, important, created', 'required');
        $rules[] = array('model_id, sort_order, important', 'numerical', 'integerOnly'=>true);
        $rules[] = array('model', 'length', 'max'=>255);
        $rules[] = array('deleted', 'safe');
        return $rules;
    }

    /**
     * @return array containing model behaviors
     */
    public function behaviors()
    {
        return array(
            'AuditBehavior' => 'behaviors.AuditBehavior',
            'TimestampBehavior' => 'behaviors.TimestampBehavior',
            'SoftDeleteBehavior' => 'behaviors.SoftDeleteBehavior',
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => t('ID'),
            'notes' => t('Notes'),
            'model' => t('Model'),
            'model_id' => t('Model'),
            'sort_order' => t('Sort Order'),
            'important' => t('Important'),
            'created' => t('Created'),
            'deleted' => t('Deleted'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param array $options
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($options = array())
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('notes',$this->notes,true);
        $criteria->compare('model',$this->model,true);
        $criteria->compare('model_id',$this->model_id);
        $criteria->compare('sort_order',$this->sort_order);
        $criteria->compare('important',$this->important);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('deleted',$this->deleted,true);

        return new ActiveDataProvider($this, CMap::mergeArray(array(
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
                $more[] = array('label' => t('Delete'), 'url' => $this->getUrl('delete', array('returnUrl' => ReturnUrl::getLinkValue(true))), 'linkOptions' => array('data-toggle' => 'modal-remote'));
            else
                $more[] = array('label' => t('Undelete'), 'url' => $this->getUrl('delete', array('task' => 'undelete', 'returnUrl' => ReturnUrl::getLinkValue(true))), 'linkOptions' => array('data-toggle' => 'modal-remote'));
            $links[] = array(
                'label' => t('More'),
                'items' => $more,
            );
        }
        return $links;
    }

}


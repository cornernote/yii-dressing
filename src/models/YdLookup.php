<?php
/**
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'lookup'
 *
 * @method Lookup with() with()
 * @method Lookup find() find($condition, array $params = array())
 * @method Lookup[] findAll() findAll($condition = '', array $params = array())
 * @method Lookup findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method Lookup[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method Lookup findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method Lookup[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method Lookup findBySql() findBySql($sql, array $params = array())
 * @method Lookup[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Methods from behavior SoftDeleteBehavior
 * @method undelete() undelete()
 * @method deleteds() deleteds()
 * @method notdeleteds() notdeleteds()
 *
 * Properties from table fields
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property integer $sort_order
 * @property datetime $created
 * @property datetime $deleted
 *
 * --- END GenerateProperties ---
 */

class YdLookup extends YdActiveRecord
{

    /**
     * @var array
     */
    private static $_items = array();

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Lookup the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        $rules = array();
        $rules[] = array('name, type, position, created', 'required');
        $rules[] = array('position', 'numerical', 'integerOnly' => true);
        $rules[] = array('name, type', 'length', 'max' => 128);
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
            'id' => Yii::t('dressing', 'ID'),
            'name' => Yii::t('dressing', 'Name'),
            'type' => Yii::t('dressing', 'Type'),
            'position' => Yii::t('dressing', 'Position'),
            'created' => Yii::t('dressing', 'Created'),
            'deleted' => Yii::t('dressing', 'Deleted'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('position', $this->position);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('deleted', $this->deleted, true);

        return new YdActiveDataProvider($this, CMap::mergeArray(array(
            'criteria' => $criteria,
        ), $options));
    }

    /**
     * Retrieves a list of links to be used in grid and menus.
     * @param bool $extra
     * @return array
     */
    public function getMenuLinks($extra = false)
    {
        $links = array();
        $links[] = array('label' => Yii::t('dressing', 'Update'), 'url' => $this->getUrl('update'));
        if ($extra) {
            $more = array();
            $more[] = array('label' => Yii::t('dressing', 'Log'), 'url' => $this->getUrl('log'));
            if (!$this->deleted)
                $more[] = array('label' => Yii::t('dressing', 'Delete'), 'url' => $this->getUrl('delete', array('returnUrl' => Yii::app()->returnUrl->getLinkValue(true))), 'linkOptions' => array('data-toggle' => 'modal-remote'));
            else
                $more[] = array('label' => Yii::t('dressing', 'Undelete'), 'url' => $this->getUrl('delete', array('task' => 'undelete', 'returnUrl' => Yii::app()->returnUrl->getLinkValue(true))), 'linkOptions' => array('data-toggle' => 'modal-remote'));
            $links[] = array(
                'label' => Yii::t('dressing', 'More'),
                'items' => $more,
            );
        }
        return $links;
    }

    /**
     * @static
     * @param $type
     * @return array
     */
    public static function items($type)
    {
        if (!isset(self::$_items[$type]))
            self::loadItems($type);
        return self::$_items[$type];
    }

    /**
     * @static
     * @param $type
     * @param $code
     * @return mixed
     */
    public static function item($type, $code)
    {
        if (!isset(self::$_items[$type]))
            self::loadItems($type);
        if (!isset(self::$_items[$type][$code])) {
            self::$_items[$type][$code] = null;
        }
        return self::$_items[$type][$code];
    }

    /**
     * @static
     * @param $type
     * @return mixed
     */
    private static function loadItems($type)
    {
        $cacheItems = Yii::app()->cache->get('Lookup.loadItems.' . $type);
        if ($cacheItems !== false) {
            self::$_items[$type] = $cacheItems;
            return;
        }
        self::$_items[$type] = array();
        $models = self::model()->findAll(array(
            'condition' => 'type=:type AND deleted IS NULL',
            'params' => array(':type' => $type),
            'order' => 'position, name',
        ));
        foreach ($models as $model) {
            self::$_items[$type][$model->code] = $model->name;
        }
        Yii::app()->cache->set('Lookup.loadItems.' . $type, self::$_items[$type]);

    }

    /**
     *
     */
    public function clearCache()
    {
        if ($this->type) {
            Yii::app()->cache->delete('Lookup.loadItems.' . $this->type);
        }
        parent::clearCache();
    }

}


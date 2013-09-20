<?php

/**
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'log'
 *
 * @method Log with() with()
 * @method Log find() find($condition, array $params = array())
 * @method Log[] findAll() findAll($condition = '', array $params = array())
 * @method Log findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method Log[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method Log findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method Log[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method Log findBySql() findBySql($sql, array $params = array())
 * @method Log[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Properties from relation
 * @property User $user
 *
 * Properties from table fields
 * @property integer $id
 * @property string $ip
 * @property integer $user_id
 * @property string $model
 * @property integer $model_id
 * @property string $message
 * @property string $details
 * @property datetime $created
 *
 * --- END GenerateProperties ---
 */
class YdLog extends CActiveRecord
{

    /**
     * @var bool
     */
    public $modelCache = false;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return Log the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'log';
    }

    /**
     * Add a row to the log table
     * @param $message
     * @param array $fields
     * @return bool|Log
     */
    public function add($message, $fields = array())
    {
        $log = new Log;
        $log->ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
        $log->message = $message;
        $log->user_id = user()->id;
        $log->created = date('Y-m-d H:i:s');
        if (isset($fields['model'])) {
            $log->model = $fields['model'];
        }
        if (isset($fields['model_id'])) {
            $log->model_id = $fields['model_id'];
        }
        if (isset($fields['details'])) {
            $log->details = serialize($fields['details']);
        }
        return $log->save();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            // search fields
            array('id, ip, type, created, status, details', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(
                self::BELONGS_TO,
                'User',
                'user_id',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => t('ID'),
            'ip' => t('IP'),
            'type' => t('Type'),
            'created' => t('Created'),
            'status' => t('Status'),
            'details' => t('Details'),
        );
    }


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param array $options
     * @return ActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($options = array())
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.model_id', $this->model_id);
        $criteria->compare('t.ip', $this->ip, true);
        $criteria->compare('t.created', $this->created);
        $criteria->compare('t.details', $this->details);

        return new ActiveDataProvider(get_class($this), CMap::mergeArray(array(
            'criteria' => $criteria,
        ), $options));
    }
}
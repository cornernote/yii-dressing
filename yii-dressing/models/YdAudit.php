<?php

/**
 * YdAudit
 *
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'audit'
 *
 * @method YdAudit with() with()
 * @method YdAudit find() find($condition, array $params = array())
 * @method YdAudit[] findAll() findAll($condition = '', array $params = array())
 * @method YdAudit findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method YdAudit[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method YdAudit findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdAudit[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdAudit findBySql() findBySql($sql, array $params = array())
 * @method YdAudit[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Properties from relation
 * @property YdUser $user
 * @property YdAuditTrail[] $auditTrail
 * @property integer $auditTrailCount
 *
 * Properties from table fields
 * @property integer $id
 * @property string $link
 * @property integer $user_id
 * @property string $ip
 * @property string $post
 * @property string $get
 * @property string $files
 * @property string $session
 * @property string $server
 * @property string $cookie
 * @property string $referrer
 * @property string $redirect
 * @property integer $audit_trail_count
 * @property number $start_time
 * @property number $end_time
 * @property number $total_time
 * @property integer $memory_usage
 * @property integer $memory_peak
 * @property datetime $created
 * @property integer $preserve
 *
 * --- END GenerateProperties ---
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.models
 */
class YdAudit extends YdActiveRecord
{

    /**
     * @var string used in search
     */
    public $model;

    /**
     * @var string|int used in search
     */
    public $model_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return YdAudit the static model class
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
        return array(
            array('id, user_id, link, ip, created, audit_trail_count, total_time, memory_usage, memory_peak, model, model_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return string
     */
    public function getLinkString()
    {
        $link = $this->link;
        $path = Yii::app()->getRequest()->getHostInfo() . Yii::app()->request->baseUrl;
        if (strpos($link, $path) === 0) {
            $link = substr($link, strlen($path));
        }
        if (strlen($link) < 64)
            return $link;
        return substr($link, 0, 64) . '...';
    }


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param array $options
     * @return YdActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($options = array())
    {
        $criteria = new CDbCriteria;
        if (strpos($this->id, 'range ') !== false) {
            $id = trim(str_replace('range ', '', $this->id));
            list($start, $end) = explode('-', $id);
            $criteria->addBetweenCondition('t.id', trim($start), trim($end));
        }
        else {
            $criteria->compare('t.id', $this->id);
        }

        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.created', $this->created);
        $criteria->compare('t.link', $this->link, true);
        $criteria->compare('t.audit_trail_count', $this->audit_trail_count);
        $criteria->compare('t.total_time', $this->total_time);
        $criteria->compare('t.memory_usage', $this->memory_usage);
        $criteria->compare('t.memory_peak', $this->memory_peak);
        $criteria->mergeWith($this->getDbCriteria());

        if ($this->model) {
            $criteria->distinct = true;
            $criteria->compare('t.audit_trail_count', '>0');
            //$criteria->group = 't.id';
            $criteria->join .= ' INNER JOIN audit_trail ON audit_trail.audit_id=t.id ';
            $criteria->compare('audit_trail.model', $this->model);
            if ($this->model_id) {
                $criteria->compare('audit_trail.model_id', $this->model_id);
            }
        }

        return new YdActiveDataProvider(get_class($this), CMap::mergeArray(array(
            'criteria' => $criteria,
        ), $options));
    }


    /**
     * @return string
     */
    public function getControllerName()
    {
        return 'audit';
    }

    /**
     * @param $attribute
     * @return string
     */
    public function pack($attribute)
    {
        $value = $this->$attribute;
        //already packed
        @$alreadyDecoded = is_array(unserialize(gzuncompress(base64_decode($value))));
        if ($alreadyDecoded) {
            echo "<br/> already decoded  <br/>\r\n";
            return;
        }
        $value = serialize($value);
        $value = gzcompress($value);
        $value = base64_encode($value);
        return $value;
    }

    /**
     * @param $attribute
     * @return mixed
     */
    public function unpack($attribute)
    {
        @$value = unserialize($this->$attribute);
        if ($value !== false) {
            $this->$attribute = $value;
            return false;
        }
        $value = base64_decode($this->$attribute);
        if (!$value) {
            return false;
        }

        @$value = gzuncompress($value);
        if ($value === false) {
            $this->$attribute = "could not uncompress [" . var_dump($value) . "]";
            return false;
        }
        @$value = unserialize($value);
        if ($value === false) {
            $this->$attribute = "could not unserialize [" . var_dump($value) . "]";
        }
        return $value;
    }

}

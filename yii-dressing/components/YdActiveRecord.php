<?php
/**
 * YdActiveRecord
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdActiveRecord extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className
     * @return YdAttachment the static model class
     */
    public static function model($className = null)
    {
        if (!$className)
            $className = get_called_class();
        return parent::model($className);
    }

    /**
     * Allows setting default attributes before validation and saving in a single method.
     *
     * @see beforeValidate()
     * @see beforeSave()
     */
    public function setDefaultAttributes()
    {
    }

    /**
     * Actions to be performed before the model is saved
     *
     * @return bool
     */
    protected function beforeValidate()
    {
        $this->setDefaultAttributes();
        return parent::beforeValidate();
    }

    /**
     * Actions to be performed before the model is saved
     *
     * @return bool
     */
    protected function beforeSave()
    {
        $this->setDefaultAttributes();
        return parent::beforeSave();
    }

    /**
     * Returns error array as a string
     *
     * @return string
     */
    public function getErrorString()
    {
        $output = array();
        foreach ($this->getErrors() as $attribute => $errors) {
            $output[] = $attribute . ': ' . implode(' ', $errors);
        }
        return implode(' | ', $output);
    }

    /**
     * Guess the table name based on the class
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        if (!empty(Yii::app()->dressing->modelMap[get_class($this)]['tableName']))
            return Yii::app()->dressing->modelMap[get_class($this)]['tableName'];
        //throw new CException(Yii::t('dressing', 'Table not found in YiiDressing::tableMap for class :class.', array(':class' => get_class($this))));
        return str_replace('yd_', '', strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', get_class($this))));
    }

    /**
     * Returns the relations used for the model
     *
     * @return array
     * @see YdDressing::modelMap
     */
    public function relations()
    {
        if (!empty(Yii::app()->dressing->modelMap[get_class($this)]['relations']))
            return Yii::app()->dressing->modelMap[get_class($this)]['relations'];
        return parent::relations();
    }

    /**
     * Returns the behaviors used for the model
     *
     * @return array
     * @see YdDressing::modelMap
     */
    public function behaviors()
    {
        if (!empty(Yii::app()->dressing->modelMap[get_class($this)]['behaviors']))
            return Yii::app()->dressing->modelMap[get_class($this)]['behaviors'];
        return parent::behaviors();
    }
}

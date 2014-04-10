<?php

/**
 * YdSetting
 *
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'setting'
 *
 * @method YdSetting with() with()
 * @method YdSetting find() find($condition, array $params = array())
 * @method YdSetting[] findAll() findAll($condition = '', array $params = array())
 * @method YdSetting findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method YdSetting[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method YdSetting findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdSetting[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdSetting findBySql() findBySql($sql, array $params = array())
 * @method YdSetting[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Methods from behavior EavBehavior
 * @method CActiveRecord loadEavAttributes() loadEavAttributes(array $attributes)
 * @method setModelTableFk() setModelTableFk($modelTableFk)
 * @method setSafeAttributes() setSafeAttributes($safeAttributes)
 * @method CActiveRecord saveEavAttributes() saveEavAttributes($attributes)
 * @method CActiveRecord deleteEavAttributes() deleteEavAttributes($attributes = array(), $save = false)
 * @method CActiveRecord setEavAttributes() setEavAttributes($attributes, $save = false)
 * @method CActiveRecord setEavAttribute() setEavAttribute($attribute, $value, $save = false)
 * @method array getEavAttributes() getEavAttributes($attributes = array())
 * @method getEavAttribute() getEavAttribute($attribute)
 * @method CActiveRecord withEavAttributes() withEavAttributes($attributes = array())
 *
 * Properties from table fields
 * @property string $key
 * @property string $value
 *
 * --- END GenerateProperties ---
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.models
 */
class YdSetting extends YdActiveRecord
{

    /**
     * @var array
     */
    private static $_items = array();

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return YdSetting the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'value' => YdCakeInflector::humanize($this->key),
        );
    }

    /**
     * @static
     * @param string $name
     * @return string
     */
    public static function item($name)
    {
        if (!self::$_items)
            self::loadItems();
        if (isset(self::$_items[$name]))
            return self::$_items[$name];

        return param($name);
    }

    /**
     *
     */
    private static function loadItems()
    {
        foreach (self::model()->findAll() as $setting)
            self::$_items[$setting->key] = $setting->value;
    }

}
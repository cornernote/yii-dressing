<?php

/**
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'setting'
 *
 * @method Setting with() with()
 * @method Setting find() find($condition, array $params = array())
 * @method Setting[] findAll() findAll($condition = '', array $params = array())
 * @method Setting findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method Setting[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method Setting findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method Setting[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method Setting findBySql() findBySql($sql, array $params = array())
 * @method Setting[] findAllBySql() findAllBySql($sql, array $params = array())
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
 */
class YdSetting extends YdActiveRecord
{

    /**
     * @var array
     */
    static private $_items = array();

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return Setting the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array containing model behaviors
     */
    public function behaviors()
    {
        return array(
            'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
        );
    }

    /**
     * @static
     * @param string $name
     * @return string
     */
    public static function item($name)
    {
        if (isset(self::$_items[$name])) {
            return self::$_items[$name];
        }
        $items = self::items();
        if (isset($items[$name])) {
            return $items[$name];
        }
        return isset(Yii::app()->params[$name]) ? Yii::app()->params[$name] : false;
    }

    /**
     * @static
     * @return array
     */
    public static function items()
    {
        if (self::$_items) {
            return self::$_items;
        }
        return self::$_items = $_ENV['_config']['setting'];
    }


    /**
     * @return array
     */
    static public function appVersions()
    {
        $_versions = array();
        $p = dirname(Yii::app()->basePath);
        $d = dir($p);
        while (false !== ($entry = $d->read())) {
            if (substr($entry, 0, 3) == 'app') {
                $time = filemtime($p . DIRECTORY_SEPARATOR . $entry);
                $_versions[$time] = array(
                    'entry' => $entry,
                    'display' => $entry . ' -- ' . YdTime::date($time, self::item('dateTimeFormat')) . ' -- (' . YdTime::ago($time) . ')',
                );
            }
        }
        $d->close();
        krsort($_versions);
        $versions = array();
        foreach ($_versions as $version) {
            $versions[$version['entry']] = $version['display'];
        }
        return $versions;
    }

    /**
     * @return array
     */
    static public function themes()
    {
        $_themes = array();
        $p = Yii::app()->themeManager->basePath;
        $d = dir($p);
        while (false !== ($entry = $d->read())) {
            $time = filemtime($p . DIRECTORY_SEPARATOR . $entry);
            $_themes[$time] = array(
                'entry' => $entry,
                'display' => $entry . ' -- ' . YdTime::date($time, self::item('dateTimeFormat')) . ' -- (' . YdTime::ago($time) . ')',
            );
        }
        $d->close();
        krsort($_themes);
        $themes = array();
        foreach ($_themes as $theme) {
            $themes[$theme['entry']] = $theme['display'];
        }
        return $themes;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'value' => YdStringHelper::humanize($this->key),
        );
    }

}
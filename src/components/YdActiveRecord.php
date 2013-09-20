<?php
/**
 * Override CActiveRecord
 *
 * @package components
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class YdActiveRecord extends CActiveRecord
{
    /**
     * The attributes that are currently in the database
     *
     * @see ActiveRecord::getDbAttribute()
     * @var array
     */
    public $dbAttributes = array();

    /**
     * If we should use a table to cache this
     *
     * @var bool
     */
    public $modelCache = true;

    /**
     * An array of the models to clear cache when this models cache is cleared
     *
     * @var array
     */
    public $cacheRelations = array();

    /**
     * Repopulates this active record with the latest data.
     *
     * @return boolean whether the row still exists in the database. If true, the latest data will be populated to this active record.
     */
    public function refresh()
    {
        $this->clearCache();
        return parent::refresh();
    }

    /**
     * Allows setting attributes
     *
     * @see ActiveRecord::beforeValidate()
     * @see ActiveRecord::beforeSave()
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
     * Actions to be performed after the model is saved
     */
    protected function afterSave()
    {
        // afterSave needs to be called before resetting dbAttributes in order for behaviours
        // such as AuditTrail to have the correct dbAttributes values
        parent::afterSave();
        $this->dbAttributes = $this->attributes;
        $this->clearCache();
    }

    /**
     * Actions to be performed before the model is deleted
     */
    protected function beforeDelete()
    {
        foreach ($this->cacheRelations as $cacheRelation)
            $this->$cacheRelation; // touch to allow afterDelete() to clearCache()
        return parent::beforeDelete();
    }

    /**
     * Actions to be performed after the model is deleted
     */
    protected function afterDelete()
    {
        $this->clearCache();
        parent::afterDelete();
    }

    /**
     * Actions to be performed after the model is loaded
     */
    protected function afterFind()
    {
        $this->dbAttributes = $this->attributes;
        parent::afterFind();
    }

    /**
     * Get a cached element
     *
     * @param $key
     * @return mixed
     */
    public function getCache($key)
    {
        $fullKey = $this->getCacheKeyPrefix() . $key;
        $return = Yii::app()->cache->get($fullKey);
        //attempt to get it from database keyvalue
        if (!$return) {
            $return = ModelCache::getCache($this, $fullKey);
        }
        return $return;
    }

    /**
     * Set a cached element
     *
     * @param $key
     * @param $value
     * @param bool $insertModelCache
     */
    public function setCache($key, $value, $insertModelCache = true)
    {
        $fullKey = $this->getCacheKeyPrefix() . $key;
        Yii::app()->cache->set($fullKey, $value);
        if ($insertModelCache) {
            ModelCache::setCache($this, $fullKey, $value);
        }

    }

    /**
     * Clear cache for this model
     */
    public function clearCache()
    {
        if (!$this->modelCache)
            return;
        // clear related cache
        foreach ($this->cacheRelations as $cacheRelation) {
            $models = is_array($this->$cacheRelation) ? $this->$cacheRelation : array($this->$cacheRelation);
            foreach ($models as $cacheRelationModel) {
                if ($cacheRelationModel instanceof ActiveRecord) {
                    $cacheRelationModel->clearCache();
                }
            }
        }
        // clear own cache
        $this->getCacheKeyPrefix($removeOldKey = true);
        ModelCache::deleteCache($this);
    }

    /**
     * Get the cache prefix for this model
     *
     * @param bool $removeOldKey
     * @return bool|string
     */
    public function getCacheKeyPrefix($removeOldKey = false)
    {
        $key = 'getCacheKeyPrefix.' . get_class($this) . '.' . $this->getPrimaryKeyString();
        $prefix = false;
        if (!$removeOldKey) {
            $prefix = Yii::app()->cache->get($key);
        }
        if (!$prefix) {
            $prefix = uniqid();
            Yii::app()->cache->set($key, $prefix);
        }
        return $prefix . '.';
    }

    /**
     * Check if any fields have changed
     *
     * @param string $field
     * @return bool|string|array
     */
    public function changed($field = null)
    {
        if ($this->isNewRecord)
            return false;
        $changed = array();
        if ($field) {
            return $this->getDbAttribute($field) != $this->{$field};
        }
        foreach ($this->attributes as $k => $v) {
            if ($this->getDbAttribute($k) != $v) {
				return true;
            }
        }
        return false;
    }

    /**
     * Lock database tables
     *
     * @param array $tables
     */
    public function lockTables($tables = array())
    {
        // $table['table_name table_alias'] = 'lock_type'
        $tables[$this->tableName()] = 'WRITE';
        $tables[$this->tableName() . ' t'] = 'WRITE';

        $tableSql = array();
        foreach ($tables as $table => $lockType) {
            $tableSql[] = $table . ' ' . $lockType;
        }
        $sql = 'LOCK TABLES ' . implode(', ', $tableSql);
        $this->getDbConnection()->createCommand($sql)->execute();
    }

    /**
     * Unlock database tables
     */
    public function unlockTables()
    {
        $sql = 'UNLOCK TABLES';
        $this->getDbConnection()->createCommand($sql)->execute();
    }

    /**
     * Begin a database transaction
     *
     * @return CDbTransaction
     */
    public function beginTransaction()
    {
        return $this->getDbConnection()->beginTransaction();
    }

    /**
     * Gets an attribute, as it is in the database
     *
     * @param $attribute
     * @return null
     */
    public function getDbAttribute($attribute)
    {
        return isset($this->dbAttributes[$attribute]) ? $this->dbAttributes[$attribute] : null;
    }

    /**
     * The name of this model to be used in links and titles
     *
     * @return string
     */
    public function getName()
    {
        return $this->getIdString();
    }

    /**
     * The name of the controller used in links
     *
     * @return string
     */
    public function getControllerName()
    {
        return lcfirst(get_class($this));
    }

    /**
     * The name and id of the model
     * eg: activeRecord-123
     *
     * @return string
     */
    public function getIdString()
    {
        return $this->getControllerName() . '-' . $this->getPrimaryKeyString();
    }

    /**
     * Returns a URL to this model
     *
     * @param string $action
     * @param array $params
     * @return string
     */
    public function getUrl($action = 'view', $params = array())
    {
        return array_merge(array(
            '/' . $this->getControllerName() . '/' . $action,
            $this->getPrimaryKeySchemaString() => $this->getPrimaryKeyString(),
        ), (array)$params);
    }

    /**
     * Returns a Link to this model
     *
     * @param string $title
     * @param string $urlAction
     * @param array $urlParams
     * @param array $htmlOptions
     * @return string
     */
    public function getLink($title = null, $urlAction = 'view', $urlParams = array(), $htmlOptions = array())
    {
        $title = $title ? $title : $this->getName();
        return l($title, $this->getUrl($urlAction, $urlParams), $htmlOptions);
    }

    /**
     * Returns an array of links to be used in TbDropdownColumn
     *
     * @return array
     */
    public function getDropdownLinks()
    {
        $links = array(
            array('label' => $this->getIdString(), 'url' => $this->getUrl()),
        );
        $items = $this->getDropdownLinkItems();
        if ($items) {
            $links[] = array('items' => $items);
        }
        return $links;
    }

    /**
     * Returns a list of links to be used in grids and menus.
     *
     * @param bool $extra
     * @return array
     */
    public function getDropdownLinkItems($extra = false)
    {
        return array();
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
     * Returns Primary Key Schema as a string
     *
     * @return string
     */
    public function getPrimaryKeySchemaString()
    {
        if (is_array($this->tableSchema->primaryKey))
            return implode('-', $this->tableSchema->primaryKey);
        return $this->tableSchema->primaryKey;
    }

    /**
     * Returns Primary Key as a string
     *
     * @return string
     */
    public function getPrimaryKeyString()
    {
        if (is_array($this->getPrimaryKey()))
            return implode('-', $this->getPrimaryKey());
        return $this->getPrimaryKey();
    }


}

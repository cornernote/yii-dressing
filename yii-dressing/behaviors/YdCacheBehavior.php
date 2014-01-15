<?php
/**
 * YdCacheBehavior allows simple assignment of cached data to a model which is automatically cleared when the model
 * is saved.  It can also automatically clear the cache of related models.
 *
 * @property YdActiveRecord $owner
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.behaviors
 */
class YdCacheBehavior extends CActiveRecordBehavior
{

    /**
     * An array of the models to clear cache when this models cache is cleared
     *
     * @var array
     */
    public $cacheRelations = array();

    /**
     * Get a cached element
     *
     * @param $key
     * @param bool $allowDbCache
     * @return mixed
     */
    public function getCache($key, $allowDbCache = false)
    {
        $fullKey = $this->getCacheKeyPrefix() . $key;
        $return = Yii::app()->cache->get($fullKey);
        //attempt to get it from database keyvalue
        if (!$return && $allowDbCache && Yii::app()->cacheDb) {
            $return = Yii::app()->cacheDb->get($fullKey);
        }
        return $return;
    }

    /**
     * Set a cached element
     *
     * @param $key
     * @param $value
     * @param bool $allowDbCache
     * @return mixed
     */
    public function setCache($key, $value, $allowDbCache = false)
    {
        $fullKey = $this->getCacheKeyPrefix() . $key;
        Yii::app()->cache->set($fullKey, $value);
        if ($allowDbCache && Yii::app()->cacheDb) {
            Yii::app()->cacheDb->set($fullKey, $value);
        }
        return $value;
    }

    /**
     * Clear cache for this model
     */
    public function clearCache()
    {
        $owner = $this->owner;
        // clear related cache
        foreach ($this->cacheRelations as $cacheRelation) {
            $models = is_array($owner->$cacheRelation) ? $owner->$cacheRelation : array($owner->$cacheRelation);
            foreach ($models as $cacheRelationModel) {
                if ($cacheRelationModel instanceof CActiveRecord) {
                    $cacheRelationModel->clearCache();
                }
            }
        }
        // clear own cache
        $this->getCacheKeyPrefix(true);
    }

    /**
     * Get the cache prefix for this model
     *
     * @param bool $removeOldKey
     * @return bool|string
     */
    private function getCacheKeyPrefix($removeOldKey = false)
    {
        $owner = $this->owner;
        $key = 'getCacheKeyPrefix.' . get_class($owner) . '.' . (is_array($owner->getPrimaryKey()) ? implode('-', $owner->getPrimaryKey()) : $owner->getPrimaryKey());
        $prefix = $removeOldKey ? false : Yii::app()->cache->get($key);
        if (!$prefix) {
            $prefix = uniqid();
            Yii::app()->cache->set($key, $prefix);
        }
        return $prefix . '.';
    }

    /**
     * @param CModelEvent $event
     */
    public function afterSave($event)
    {
        $this->clearCache();
        parent::afterSave($event);
    }

    /**
     * @param CModelEvent $event
     */
    public function beforeDelete($event)
    {
        // touch to allow afterDelete() to clearCache()
        foreach ($this->cacheRelations as $cacheRelation)
            $this->owner->$cacheRelation;
        parent::beforeDelete($event);
    }

    /**
     * @param CModelEvent $event
     */
    public function afterDelete($event)
    {
        $this->clearCache();
        parent::afterDelete($event);
    }

}

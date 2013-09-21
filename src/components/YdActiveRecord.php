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
     * Check if any fields have changed
     *
     * @param string $field
     * @return bool|string|array
     */
    public function changed($field = null)
    {
        if ($this->isNewRecord)
            return false;
        if ($field)
            return $this->getDbAttribute($field) != $this->attributes[$field];
        foreach ($this->attributes as $k => $v)
            if ($this->getDbAttribute($k) != $v)
                return true;
        return false;
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
     * The name of this model to be used in titles
     *
     * @return string
     */
    public function getName()
    {
        return $this->getIdString();
    }


    /**
     * The name of this model to be used in links
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
        return CHtml::link($title, $this->getUrl($urlAction, $urlParams), $htmlOptions);
    }

    /**
     * Returns a list of links to be used in grids and menus.
     *
     * @param bool $extra
     * @return array
     */
    public function getMenuLinks($extra = false)
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

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return Yii::app()->dressing->tableMap[get_class($this)];
    }

}

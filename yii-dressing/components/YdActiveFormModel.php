<?php
Yii::import('dressing.components.YdFormModel');

/**
 * YdActiveFormModel provides a model for ActiveForm when you don't have a model
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdActiveFormModel extends YdFormModel
{

    private $_attributes = array();

    /**
     * PHP getter magic method.
     * This method is overridden so that any attribute can be accessed.
     * @param string $name the property name or event name
     * @return mixed the property value, event handlers attached to the event, or the named behavior
     * @throws CException if the property or event is not defined
     * @see __set
     */
    public function __get($name)
    {
        try {
            return parent::__get($name);
        } catch (Exception $e) {
            if (isset($this->_attributes[$name]))
                return $this->_attributes[$name];
            if (isset($_POST['YdActiveFormModel'][$name]))
                return $this->_attributes[$name] = $_POST['YdActiveFormModel'][$name];
            return null;
        }
    }

    /**
     * PHP setter magic method.
     * This method is overridden so that any attribute can be accessed.
     * @param string $name property name
     * @param mixed $value property value
     * @return mixed|void
     * @throws CException
     */
    public function __set($name, $value)
    {
        try {
            parent::__set($name, $value);
        } catch (Exception $e) {
            $this->_attributes[$name] = $value;
            return;
        }
    }

    /**
     * Sets the attribute values in a massive way.
     * @param array $values attribute values (name=>value) to be set.
     * @param boolean $safeOnly whether the assignments should only be done to the safe attributes.
     * A safe attribute is one that is associated with a validation rule in the current {@link scenario}.
     * @see getSafeAttributeNames
     * @see attributeNames
     */
    public function setAttributes($values, $safeOnly = false)
    {
        if (!is_array($values))
            return;
        foreach ($values as $name => $value) {
            $this->_attributes[$name] = $value;
        }
    }

    /**
     * Returns all attribute values.
     * @param array $names list of attributes whose value needs to be returned.
     * Defaults to null, meaning all attributes as listed in {@link attributeNames} will be returned.
     * If it is an array, only the attributes in the array will be returned.
     * @return array attribute values (name=>value).
     */
    public function getAttributes($names = null)
    {
        $values = array();
        foreach (array_keys($this->_attributes) as $name)
            $values[$name] = $this->$name;

        if (is_array($names)) {
            $values2 = array();
            foreach ($names as $name)
                $values2[$name] = isset($values[$name]) ? $values[$name] : null;
            return $values2;
        }
        else
            return $values;
    }

}

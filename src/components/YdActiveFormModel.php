<?php

/**
 * YdActiveFormModel provides a model for ActiveForm when you don't have a model
 *
 * @package app.model
 * @author Zain <zain@mrphp.com.au>
 * @author Brett O'Donnell <brett@mrphp.com.au>
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
}

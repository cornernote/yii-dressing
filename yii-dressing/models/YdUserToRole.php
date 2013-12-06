<?php

/**
 * YdUserToRole
 *
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'user_to_role'
 *
 * @method YdUserToRole with() with()
 * @method YdUserToRole find() find($condition, array $params = array())
 * @method YdUserToRole[] findAll() findAll($condition = '', array $params = array())
 * @method YdUserToRole findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method YdUserToRole[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method YdUserToRole findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdUserToRole[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdUserToRole findBySql() findBySql($sql, array $params = array())
 * @method YdUserToRole[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Properties from table fields
 * @property string $id
 * @property string $user_id
 * @property string $role_id
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
class YdUserToRole extends YdActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return YdUserToRole the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
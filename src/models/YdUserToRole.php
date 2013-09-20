<?php

/**
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'user_to_role'
 *
 * @method UserToRole with() with()
 * @method UserToRole find() find($condition, array $params = array())
 * @method UserToRole[] findAll() findAll($condition = '', array $params = array())
 * @method UserToRole findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method UserToRole[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method UserToRole findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method UserToRole[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method UserToRole findBySql() findBySql($sql, array $params = array())
 * @method UserToRole[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Properties from table fields
 * @property string $id
 * @property string $user_id
 * @property string $role_id
 *
 * --- END GenerateProperties ---
 */
class UserToRole extends ActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return UserToRole the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user_to_role';
    }

    /**
     * @return array containing model behaviors
     */
    public function behaviors()
    {
        return array(
            'AuditBehavior' => array(
                'class' => 'behaviors.AuditBehavior',
                'additionalAuditModels' => array(
                    'User' => 'user_id',
                    'Role' => 'role_id',
                ),
            ),
        );
    }

}
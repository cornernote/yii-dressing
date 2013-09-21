<?php

/**
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'email_template'
 *
 * @method EmailTemplate with() with()
 * @method EmailTemplate find() find($condition, array $params = array())
 * @method EmailTemplate[] findAll() findAll($condition = '', array $params = array())
 * @method EmailTemplate findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method EmailTemplate[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method EmailTemplate findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method EmailTemplate[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method EmailTemplate findBySql() findBySql($sql, array $params = array())
 * @method EmailTemplate[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Properties from table fields
 * @property integer $id
 * @property string $name
 * @property string $message_subject
 * @property string $message_html
 * @property string $message_text
 * @property string $description
 * @property datetime $created
 * @property datetime $deleted
 *
 * --- END GenerateProperties ---
 */


class YdEmailTemplate extends YdActiveRecord
{
    /**
     *
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return EmailTemplate the static model class
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
        return 'email_template';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => t('ID'),
            'name' => t('Name'),
            'created' => t('Created'),
            'deleted' => t('Deleted'),
        );
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
     * @param array $rules
     * @return array validation rules for model attributes.
     */
    public function rules($rules = array())
    {
        $rules = array();

        // search
        if ($this->scenario == 'search') {
            $rules[] = array('id, name', 'safe', 'on' => 'search');
        }

        // create/update
        if (in_array($this->scenario, array('create', 'update'))) {

            // name
            $rules[] = array('name', 'required');
            $rules[] = array('name', 'length', 'max' => 255);

            // subject
            $rules[] = array('message_subject', 'required');
            $rules[] = array('message_subject', 'length', 'max' => 255);

            // text
            $rules[] = array('message_text', 'required');
            //$rules[] = array('message_text', 'length', 'max' => 255);

            // html
            $rules[] = array('message_html', 'required');
            //$rules[] = array('message_html', 'length', 'max' => 255);
        }

        return $rules;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param array $options
     * @return ActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($options = array())
    {
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->getSearchField('id', 'id'));
        $criteria->compare('t.name', $this->name, true);

        $criteria->addCondition('t.deleted IS ' . ($this->deleted == 'deleted' ? 'NOT NULL' : 'NULL'));

        return new ActiveDataProvider(get_class($this), CMap::mergeArray(array(
            'criteria' => $criteria,
        ), $options));
    }

}
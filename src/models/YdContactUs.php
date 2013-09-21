<?php
/**
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'contact_us'
 *
 * @method ContactUs with() with()
 * @method ContactUs find() find($condition, array $params = array())
 * @method ContactUs[] findAll() findAll($condition = '', array $params = array())
 * @method ContactUs findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method ContactUs[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method ContactUs findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method ContactUs[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method ContactUs findBySql() findBySql($sql, array $params = array())
 * @method ContactUs[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Properties from table fields
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $company
 * @property string $subject
 * @property string $message
 * @property string $created_at
 * @property string $ip_address
 *
 * --- END GenerateProperties ----
 */

class YdContactUs extends YdActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ContactUs the static model class
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
        return 'contact_us';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        $rules = array();
        if (in_array($this->scenario, array('create', 'update'))) {
            $rules[] = array('email, subject, message', 'required');
            $rules[] = array('name, email, phone, company, subject, created_at, ip_address', 'length', 'max' => 255);
            $rules[] = array('message', 'type', 'type' => 'string');
        }
        return $rules;
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
     * @return array relational rules.
     */
    public function relations()
    {
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => t('ID'),
            'name' => t('Name'),
            'email' => t('Email'),
            'phone' => t('Phone'),
            'company' => t('Company'),
            'subject' => t('Subject'),
            'message' => t('Message'),
            'created_at' => t('Created At'),
            'ip_address' => t('Ip Address'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param array $options
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($options = array())
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('company', $this->company, true);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('ip_address', $this->ip_address, true);

        return new ActiveDataProvider($this, CMap::mergeArray(array(
            'criteria' => $criteria,
        ), $options));
    }

    /**
     * Retrieves a list of links to be used in menus.
     * @param bool $extra
     * @return array
     */
    public function getDropdownLinkItems($extra = false)
    {
        $links = array();
        //$links[] = array('label' => t('Update'), 'url' => $this->getUrl('update'));
        return $links;
    }

}


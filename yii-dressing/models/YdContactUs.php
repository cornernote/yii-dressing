<?php
/**
 * YdContactUs
 *
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'contact_us'
 *
 * @method YdContactUs with() with()
 * @method YdContactUs find() find($condition, array $params = array())
 * @method YdContactUs[] findAll() findAll($condition = '', array $params = array())
 * @method YdContactUs findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method YdContactUs[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method YdContactUs findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdContactUs[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdContactUs findBySql() findBySql($sql, array $params = array())
 * @method YdContactUs[] findAllBySql() findAllBySql($sql, array $params = array())
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
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.models
 */

class YdContactUs extends YdActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return YdContactUs the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
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
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('dressing', 'ID'),
            'name' => Yii::t('dressing', 'Name'),
            'email' => Yii::t('dressing', 'Email'),
            'phone' => Yii::t('dressing', 'Phone'),
            'company' => Yii::t('dressing', 'Company'),
            'subject' => Yii::t('dressing', 'Subject'),
            'message' => Yii::t('dressing', 'Message'),
            'created' => Yii::t('dressing', 'Created'),
            'ip_address' => Yii::t('dressing', 'IP Address'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param array $options
     * @return YdActiveDataProvider the data provider that can return the models based on the search/filter conditions.
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
        $criteria->compare('ip_address', $this->ip_address, true);
        $criteria->compare('created', $this->created, true);

        return new YdActiveDataProvider($this, CMap::mergeArray(array(
            'criteria' => $criteria,
        ), $options));
    }

    /**
     * Retrieves a list of links to be used in menus.
     * @param bool $extra
     * @return array
     */
    public function getMenuLinks($extra = false)
    {
        $links = array();
        //$links[] = array('label' => Yii::t('dressing', 'Update'), 'url' => $this->getUrl('update'));
        return $links;
    }

}


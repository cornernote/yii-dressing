<?php
/**
 *
 * UserPassword class.
 * UserPassword is the data structure for keeping user password form data.
 * It is used by the 'password' action of 'UserController'.
 *
 * @package app.model
 * @author Brett O'Donnell <brett@mrphp.com.au>
 *
 */

class YdUserPassword extends YdFormModel
{
    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $confirm_password;

    /**
     * @var
     */
    public $current_password;

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            // current_password
            array('current_password', 'required', 'on' => 'password'),
            array('current_password', 'validateCurrentPassword', 'on' => 'password'),
            array('current_password', 'length', 'max' => 64, 'min' => 5),

            // password
            array('password', 'required'),
            array('password', 'length', 'max' => 64, 'min' => 5),

            // confirm_password
            array('confirm_password', 'required', 'on' => 'password, recover'),
            array('confirm_password', 'length', 'max' => 64, 'min' => 5),
            array('confirm_password', 'compare', 'compareAttribute' => 'password'),
        );
    }

    /**
     *
     */
    public function validateCurrentPassword()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (!$user || !$user->validatePassword($this->current_password)) {
            $this->addError('current_password', 'Incorrect password.');
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'current_password' => Yii::t('dressing', 'Current Password'),
            'password' => Yii::t('dressing', 'New Password'),
            'confirm_password' => Yii::t('dressing', 'Confirm Password'),
        );
    }

} 

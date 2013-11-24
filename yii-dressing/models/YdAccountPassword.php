<?php
/**
 * YdAccountPassword is the data structure for keeping account password form data.
 * It is used by the 'password' action of 'AccountController'.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.models
 */

class YdAccountPassword extends YdFormModel
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
        $user = YdUser::model()->findByPk(Yii::app()->user->id);
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

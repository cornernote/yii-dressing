<?php
/**
 * YdAccountPassword is the data structure for keeping account password form data.
 * It is used by the 'password' action of 'YdAccountController'.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.models
 */

class YdAccountPassword extends YdFormModel
{
    /**
     * @var
     */
    public $new_password;

    /**
     * @var
     */
    public $confirm_password;

    /**
     * @var
     */
    public $current_password;

    /**
     * @var string
     */
    public $userformClass = 'YdUser';

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

            // new_password
            array('new_password', 'required'),
            array('new_password', 'length', 'max' => 64, 'min' => 5),

            // confirm_password
            array('confirm_password', 'required', 'on' => 'password, lostPassword'),
            array('confirm_password', 'length', 'max' => 64, 'min' => 5),
            array('confirm_password', 'compare', 'compareAttribute' => 'new_password'),
        );
    }

    /**
     *
     */
    public function validateCurrentPassword()
    {
        $user = CActiveRecord::model($this->userformClass)->findByPk(Yii::app()->user->id);
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
            'new_password' => Yii::t('dressing', 'New Password'),
            'confirm_password' => Yii::t('dressing', 'Confirm Password'),
        );
    }

} 

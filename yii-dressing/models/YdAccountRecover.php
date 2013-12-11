<?php

/**
 * YdAccountRecover is the data structure for keeping account recover form data.
 * It is used by the 'recover' action of 'AccountController'.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.models
 */
class YdAccountRecover extends YdFormModel
{
    /**
     * @var
     */
    public $username_or_email;

    /**
     * @var
     */
    public $user_id;

    /**
     * @var
     */
    public $recaptcha;


    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     * @return array
     */
    public function rules()
    {
        $rules = array(
            // username_or_email
            array('username_or_email', 'required'),
            array('username_or_email', 'checkExists'),
        );
        // recaptcha
        if (isset(Yii::app()->reCaptcha)) {
            $rules[] = array('recaptcha', 'dressing.validators.YdReCaptchaValidator', 'on' => 'recaptcha');
        }
        return $rules;
    }

    /**
     * Declares attribute labels.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'username_or_email' => Yii::t('dressing', 'Username or Email'),
            'recaptcha' => Yii::t('dressing', 'Enter both words separated by a space'),
        );
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function checkExists($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (strpos($this->username_or_email, '@'))
                $user = User::model()->findByAttributes(array('email' => $this->username_or_email));
            else
                $user = User::model()->findByAttributes(array('username' => $this->username_or_email));

            if ($user === null || $user->deleted) {
                if (strpos($this->username_or_email, '@'))
                    $this->addError('username_or_email', 'Email is incorrect.');
                else
                    $this->addError('username_or_email', 'Username is incorrect.');
            }
            else {
                $this->user_id = $user->id;
            }
        }
    }

}

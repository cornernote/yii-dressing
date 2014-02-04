<?php

/**
 * YdAccountLogin is the data structure for keeping account login form data.
 * It is used by the 'login' action of 'YdAccountController'.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.models
 */
class YdAccountLogin extends YdFormModel
{

    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $rememberMe;

    /**
     * @var int
     */
    public $rememberMeDuration = 2592000; // 30 days

    /**
     * @var
     */
    public $recaptcha;

    /**
     * @var string
     */
    public $userIdentityClass = 'YdUserIdentity';

    /**
     * @var YdUserIdentity
     */
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that email and password are required,
     * and password needs to be authenticated.
     * @return array
     */
    public function rules()
    {
        $rules = array(
            // email
            array('email', 'required'),

            // password
            array('password', 'required'),
            array('password', 'authenticate', 'skipOnError' => true),

            // rememberMe
            array('rememberMe', 'boolean'),
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
            'email' => Yii::t('dressing', 'Email'),
            'password' => Yii::t('dressing', 'Password'),
            'rememberMe' => Yii::t('dressing', 'Remember me next time'),
            'recaptcha' => Yii::t('dressing', 'Enter both words separated by a space'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     * @param $attribute
     * @param $params
     */
    public function authenticate($attribute, $params)
    {
        $this->_identity = new $this->userIdentityClass($this->email, $this->password);
        if (!$this->_identity->authenticate()) {
            $this->addError('password', 'Incorrect email or password.');
        }
    }

    /**
     * Logs in the user using the given email and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if ($this->_identity === null) {
            $this->_identity = new $this->userIdentityClass($this->email, $this->password);
        }
        if ($this->_identity->authenticate()) {
            return Yii::app()->user->login($this->_identity, $this->rememberMe ? $this->rememberMeDuration : 0);
        }
        return false;
    }

}

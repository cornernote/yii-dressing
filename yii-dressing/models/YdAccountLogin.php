<?php

/**
 * YdAccountLogin is the data structure for keeping account login form data.
 * It is used by the 'login' action of 'AccountController'.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
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
    public $remember_me;

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

            // remember_me
            array('remember_me', 'boolean'),
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
            'remember_me' => Yii::t('dressing', 'Remember me next time'),
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
            $duration = $this->remember_me ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        }
        return false;
    }

}

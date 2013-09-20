<?php

/**
 * UserLogin is the data structure for keeping user login form data.
 * It is used by the 'login' action of 'UserController'.
 *
 * @package app.model
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class YdUserLogin extends FormModel
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
     * @var UserIdentity
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
        if (Setting::item('recaptcha')) {
            $rules[] = array('recaptcha', 'validators.ReCaptchaValidator', 'privateKey' => Setting::item('recaptchaPrivate'), 'on' => 'recaptcha');
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
            'email' => t('Email'),
            'password' => t('Password'),
            'remember_me' => t('Remember me next time'),
            'recaptcha' => t('Enter both words separated by a space'),
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
        $this->_identity = new UserIdentity($this->email, $this->password);
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
            $this->_identity = new UserIdentity($this->email, $this->password);
        }
        if ($this->_identity->authenticate()) {
            $duration = $this->remember_me ? 3600 * 24 * 30 : 0; // 30 days
            user()->login($this->_identity, $duration);
            return true;
        }
        return false;
    }

}

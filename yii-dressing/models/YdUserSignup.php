<?php

/**
 * YdUserSignup is the data structure for keeping user registration form data.
 * It is used by the 'signup' action of 'AccountController'.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.models
 */
class YdUserSignup extends YdFormModel
{

    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $username;

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
    public $first_name;

    /**
     * @var
     */
    public $last_name;

    /**
     * @var
     */
    public $remember_me;

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
        $rules = array();

        // required
        $rules[] = array('username, email, password, confirm_password', 'required');

        // first_name
        $rules[] = array('first_name', 'length', 'max' => 255);

        // last_name
        $rules[] = array('last_name', 'length', 'max' => 255);

        // email
        $rules[] = array('email', 'length', 'max' => 255);
        $rules[] = array('email', 'email');
        $rules[] = array('email', 'unique', 'className' => 'YdUser', 'criteria' => array('condition' => 't.deleted IS NULL'));

        // username
        $rules[] = array('username', 'length', 'max' => 255);
        $rules[] = array('username', 'unique', 'className' => 'YdUser', 'criteria' => array('condition' => 't.deleted IS NULL'));

        // confirm_password
        $rules[] = array('confirm_password', 'compare', 'compareAttribute' => 'password');

        return $rules;
    }

    /**
     * Declares attribute labels.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'username' => t('Username'),
            'first_name' => t('First Name'),
            'last_name' => t('Last Name'),
            'email' => t('Email'),
            'password' => t('Password'),
        );
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        // create user
        $user = new YdUser();
        $user->username = $this->username;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->password = $user->hashPassword($this->password);
        $user->web_status = 1;
        if (!$user->save()) {
            return false;
        }
        YdEMailHelper::sendUserWelcome($user);

        // login
        $this->login();
        return $user;
    }


    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if ($this->_identity === null) {
            $this->_identity = new YdUserIdentity($this->email, $this->password);
        }
        if ($this->_identity->authenticate()) {
            $duration = $this->remember_me ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        }
        return false;
    }

}

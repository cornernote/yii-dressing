<?php

/**
 * YdAccountSignup is the data structure for keeping account registration form data.
 * It is used by the 'signup' action of 'YdAccountController'.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.models
 */
class YdAccountSignup extends YdFormModel
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
    public $userClass = 'YdUser';

    /**
     * @var
     */
    public $userIdentityClass = 'YdUserIdentity';

    /**
     * @var YdUser
     */
    public $user;

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
        $rules[] = array('email', 'unique', 'className' => $this->userClass);

        // username
        $rules[] = array('username', 'length', 'max' => 255);
        $rules[] = array('username', 'unique', 'className' => $this->userClass);

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
        $this->user = new $this->userClass();
        $this->user->username = $this->username;
        $this->user->first_name = $this->first_name;
        $this->user->last_name = $this->last_name;
        $this->user->email = $this->email;
        $this->user->password = $this->user->hashPassword($this->password);
        if (!$this->user->save()) {
            return false;
        }

        // login
        $this->login();
        return $this->user;
    }


    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if ($this->_identity === null) {
            $this->_identity = new $this->userIdentityClass($this->email, $this->password);
        }
        if ($this->_identity->authenticate()) {
            Yii::app()->user->login($this->_identity);
            return true;
        }
        return false;
    }

}

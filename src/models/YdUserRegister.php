<?php

/**
 * UserRegister is the data structure for keeping user registration form data.
 *
 * @package app.model
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class UserRegister extends FormModel
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
    public $name;

    /**
     * @var
     */
    public $remember_me;

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
        $rules = array();

        // required
        $rules[] = array('name, email, password', 'required');

        // email
        $rules[] = array('email', 'length', 'max' => 255);
        $rules[] = array('email', 'email');
        $rules[] = array('email', 'unique', 'className' => 'User', 'criteria' => array('condition' => 't.deleted IS NULL'));

        // name
        $rules[] = array('name', 'required');
        $rules[] = array('name', 'length', 'max' => 255);

        return $rules;
    }

    /**
     * Declares attribute labels.
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'name' => t('Company'),
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
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = $user->hashPassword($this->password);
        $user->web_status = 1;
        if (!$user->save()) {
            return false;
        }
        email()->sendWelcomeEmail($user);

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

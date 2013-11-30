<?php
/**
 * Class YdUserIdentity
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.components
 */
class YdUserIdentity extends CUserIdentity
{
    /**
     * @var
     */
    private $_id;

    /**
     * Authentication for Standard Login
     *
     * @return bool
     */
    public function authenticate()
    {
        $username = strtolower($this->username);
        $user = YdUser::model()->find('(LOWER(username)=? OR LOWER(email)=?) AND web_status=1 AND deleted IS NULL', array(
            $username,
            $username,
        ));
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        else {
            if (!$user->validatePassword($this->password))
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            else {
                $this->_id = $user->id;
                $this->username = $user->username ? $user->username : $user->email;
                $this->errorCode = self::ERROR_NONE;
                Yii::app()->session->add('YdUserIdentity.web', true);
            }
        }

        // returns true if no error, false if error
        return $this->errorCode == self::ERROR_NONE;
    }

    /**
     * Authentication for API Login
     *
     * @return bool
     */
    public function authenticateApi()
    {
        $username = strtolower($this->username);
        $user = YdUser::model()->find('(LOWER(username)=? OR LOWER(email)=?) AND api_status=1 AND deleted IS NULL', array(
            $username,
            $username,
        ));
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        else {
            if (!$user->validatePassword($this->password, $user->api_key))
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            else {
                $this->_id = $user->id;
                $this->username = $user->username ? $user->username : $user->email;
                $this->errorCode = self::ERROR_NONE;
                Yii::app()->session->add('YdUserIdentity.api', true);
            }
        }

        // returns true if no error, false if error
        return $this->errorCode == self::ERROR_NONE;
    }

    /**
     * Authentication for Change User
     *
     * @return bool
     */
    public function authenticateChangeUser()
    {
        $username = strtolower($this->username);
        $user = YdUser::model()->find('(LOWER(username)=? OR LOWER(email)=?) AND web_status=1 AND deleted IS NULL', array(
            $username,
            $username,
        ));
        if ($user === null) {
            return $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        if ($this->password != Yii::app()->user->user->password)
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->_id = $user->id;
            $this->username = $user->username ? $user->username : $user->email;
            $this->errorCode = self::ERROR_NONE;
        }

        // returns true if no error, false if error
        return $this->errorCode == self::ERROR_NONE;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

}

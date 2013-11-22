<?php

/**
 * Class YdMailChimp
 */
class YdMailChimp extends CApplicationComponent
{
    /**
     * @var string
     */
    public $apiKey;

    /**
     * @var string
     */
    public $list;

    /**
     * @var YdMailChimpAPI
     */
    private $_mcapi;

    /**
     * @param null $apiKey
     * @return MCAPI
     */
    public function getMCAPI($apiKey = null)
    {
        if ($this->_mcapi)
            return $this->_mcapi;
        return $this->_mcapi = new YdMailChimp($apiKey ? $apiKey : $this->apiKey);
    }

    /**
     * @param $email
     * @param null $list
     * @return mixed
     */
    public function unsubscribe($email, $list = null)
    {
        return $this->getMCAPI()->listUnsubscribe($list ? $list : $this->list, $email, false, false, true);
    }

    /**
     * @param $email
     * @param null $list
     * @return mixed
     */
    public function subscribe($email, $list = null)
    {
        return $this->getMCAPI()->listSubscribe($list ? $list : $this->list, $email, array('INTERESTS' => ''), 'html', false, true, false, false);
    }

    /**
     * @param $email
     * @param null $list
     * @return bool
     */
    public function subscribed($email, $list = null)
    {
        $user = $this->getMCAPI()->listMemberInfo($list ? $list : $this->list, $email);
        return ($user && $user['status'] == 'subscribed') ? true : false;
    }

    /**
     * @param $email
     * @param null $list
     * @return bool
     */
    public function unsubscribed($email, $list = null)
    {
        $user = $this->getMCAPI()->listMemberInfo($list ? $list : $this->list, $email);
        return (!$user || $user['status'] == 'subscribed') ? false : true;
    }

    /**
     * @param $email
     * @param null $list
     * @return array|bool
     */
    public function exists($email, $list = null)
    {
        $user = $this->getMCAPI()->listMemberInfo($list ? $list : $this->list, $email);
        return $user ? $user : false;
    }

    /**
     * @param $email
     * @param null $list
     * @return bool
     */
    public function subscribeIfNotExists($email, $list = null)
    {
        if (!$this->exists($email, $list ? $list : $this->list)) {
            return $this->subscribe($email, $list ? $list : $this->list);
        }
        return false;
    }

}
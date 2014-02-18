<?php

/**
 * Class YdMailChimp
 *
 * @package dressing.components
 */
class YdMailChimp extends CApplicationComponent
{
    /**
     * @var string
     */
    public $apiKey;

    /**
     * @var array
     */
    public $lists = array();

    /**
     * @var string
     */
    public $defaultList;

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
        Yii::import('dressing.components.YdMailChimpAPI');
        return $this->_mcapi = new YdMailChimpAPI($apiKey ? $apiKey : $this->apiKey);
    }

    public function getList($list)
    {
        return $this->lists[$list ? $list : $this->defaultList];
    }

    /**
     * @param $email
     * @param null $list
     * @return mixed
     */
    public function unsubscribe($email, $list = null)
    {
        return $this->getMCAPI()->listUnsubscribe($this->getList($list), $email, false, false, true);
    }

    /**
     * @param $email
     * @param null $list
     * @return mixed
     */
    public function subscribe($email, $list = null)
    {
        return $this->getMCAPI()->listSubscribe($this->getList($list), $email, array('INTERESTS' => ''), 'html', false, true, false, false);
    }

    /**
     * @param $email
     * @param null $list
     * @return bool
     */
    public function subscribed($email, $list = null)
    {
        $user = $this->getMCAPI()->listMemberInfo($this->getList($list), $email);
        return ($user && $user['status'] == 'subscribed') ? true : false;
    }

    /**
     * @param $email
     * @param null $list
     * @return bool
     */
    public function unsubscribed($email, $list = null)
    {
        $user = $this->getMCAPI()->listMemberInfo($this->getList($list), $email);
        return (!$user || $user['status'] == 'subscribed') ? false : true;
    }

    /**
     * @param $email
     * @param null $list
     * @return array|bool
     */
    public function exists($email, $list = null)
    {
        $user = $this->getMCAPI()->listMemberInfo($this->getList($list), $email);
        return $user ? $user : false;
    }

    /**
     * @param $email
     * @param null $list
     * @return bool
     */
    public function subscribeIfNotExists($email, $list = null)
    {
        if (!$this->exists($email, $list))
            return $this->subscribe($email, $this->getList($list));
        return false;
    }

}
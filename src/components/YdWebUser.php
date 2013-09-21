<?php
/**
 *
 * @property YdUser $user
 * @property integer $id
 * @property bool $api
 */
class YdWebUser extends CWebUser
{

    const MF_KEY_PREFIX = 'mf';
    const MF_MAX = 100;

    /**
     * @var YdUser
     */
    private $_userModel;

    /**
     * Initializes the application component.
     * This method overrides the parent implementation by starting session,
     * performing cookie-based authentication if enabled, and updating the flash variables.
     */
    public function init()
    {
        if (get_class(Yii::app()) != 'CConsoleApplication') {
            parent::init();
        }
    }

    /**
     * Performs access check for this user.
     * @param string $operation the name of the operation that need access check.
     * @param array $params name-value pairs that would be passed to business rules associated
     * with the tasks and roles assigned to the user.
     * @param boolean $allowCaching whether to allow caching the result of access check.
     * This parameter has been available since version 1.0.5. When this parameter
     * is true (default), if the access check of an operation was performed before,
     * its result will be directly returned when calling this method to check the same operation.
     * If this parameter is false, this method will always call {@link CAuthManager::checkAccess}
     * to obtain the up-to-date access result. Note that this caching is effective
     * only within the same request.
     * @return boolean whether the operations can be performed by this user.
     */
    public function checkAccess($operation, $params = array(), $allowCaching = true)
    {
        if (!$this->user) {
            return false;
        }
        return $this->user->checkAccess($operation);
    }

    /**
     * Add flash to the stack.
     * @param string $msg
     * @param string $class
     */
    public function addFlash($msg = '', $class = 'info')
    {
        $key = $this->getNexMultiFlashKey();
        if ($key === false)
            Yii::trace("Stack overflow in addFlash", 'dressing.YdWebUser.addFlash()');
        else
            $this->setFlash($key, array($msg, $class));
    }

    /**
     * Returns next flash key for addFlash function.
     * @return mixed string if ok or bool false if there was stack overflow.
     */
    protected function getNexMultiFlashKey()
    {
        $counters = $this->getState(self::FLASH_COUNTERS, array());
        if (empty($counters)) return self::MF_KEY_PREFIX . "1";
        for ($i = 1; $i <= self::MF_MAX; $i++) {
            $key = self::MF_KEY_PREFIX . (string)$i;
            if (array_key_exists($key, $counters)) continue;
            return $key;
        }
        return false;
    }

    /**
     * Gets all flashes and shows them to the user.
     * Every flash is div with css class 'flash' and another 'flash_xxx' where xxx is the $class
     * parameter set in addFlash function.
     * Examples:
     * Yii::app()->user->addFlash('My text, something important!', 'warning');
     * Yii::app()->multiFlash();
     * Output is <div class="flash flash_warning">My text, something important!<div>
     * @return string
     */
    public function multiFlash()
    {
        $output = '';
        for ($i = 1; $i <= self::MF_MAX; $i++) {
            $key = self::MF_KEY_PREFIX . (string)$i;
            if (!$this->hasFlash($key)) continue;
            list($msg, $class) = $this->getFlash($key);
            $output .= "<div class=\"alert alert-$class\">$msg</div>\n";
        }
        return $output;
    }

    /**
     * Load user model
     * @param null $id
     * @return YdUser
     */
    function getUser($id = null)
    {
        if ($this->_userModel === null && YdHelper::tableExists(Yii::app()->dressing->tableMap['YdUser'])) {
            if ($id !== null)
                $this->_userModel = YdUser::model()->findByPk($id);
            else
                $this->_userModel = YdUser::model()->findByPk(Yii::app()->user->id);
        }
        return $this->_userModel;
    }

    /**
     * Load user setting
     * @param $name
     * @return string
     */
    function setting($name)
    {
        if (!$this->user) {
            return false;
        }
        $setting = $this->user->getEavAttribute($name);
        if (!$setting) {
            $setting = YdSetting::item($name);
        }
        return $setting;
    }

}
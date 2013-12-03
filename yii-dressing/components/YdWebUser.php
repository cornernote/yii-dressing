<?php
/**
 *
 * Methods from behavior YdWebUserFlashBehavior
 * @method multiFlash() multiFlash()
 * @method addFlash() addFlash(string $message, string $class = 'info')
 *
 * Properties from getters
 * @property YdUser $user
 * @property integer $id
 * @property bool $api
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.components
 */
class YdWebUser extends CWebUser
{

    /**
     * @var bool
     */
    public $allowAutoLogin = true;

    /**
     * @var array
     */
    public $loginUrl = array('/account/login');

    /**
     * @var YdUser
     */
    protected $_userModel;

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
     * Load user model
     * @param null $id
     * @return YdUser
     */
    public function getUser($id = null)
    {
        if ($this->_userModel === null && YdHelper::tableExists(YdUser::model()->tableName())) {
            $this->_userModel = YdUser::model()->findByPk($id !== null ? $id : $this->id);
        }
        return $this->_userModel;
    }

}
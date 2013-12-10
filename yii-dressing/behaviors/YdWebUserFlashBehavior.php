<?php
/**
 *
 * @property CWebUser $owner
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.behaviors
 */
class YdWebUserFlashBehavior extends CBehavior
{

    /**
     *
     */
    const MF_KEY_PREFIX = 'mf';

    /**
     *
     */
    const MF_MAX = 100;

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
            $this->owner->setFlash($key, array($msg, $class));
    }

    /**
     * Returns next flash key for addFlash function.
     * @return mixed string if ok or bool false if there was stack overflow.
     */
    protected function getNexMultiFlashKey()
    {
        $counters = $this->owner->getState(CWebUser::FLASH_COUNTERS, array());
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
            if (!$this->owner->hasFlash($key)) continue;
            list($msg, $class) = $this->owner->getFlash($key);
            $output .= "<div class=\"alert alert-$class\">$msg</div>\n";
        }
        return $output;
    }

}
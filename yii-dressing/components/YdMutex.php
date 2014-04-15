<?php

/**
 * YdMutex provides a locking mechanisim (mutual exclusion) for parts of the application.
 *
 * @author Y!!
 * @link http://www.yiiframework.com/extension/mutex/
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdMutex extends CApplicationComponent
{

    /**
     * @var
     */
    public $mutexFile;

    /**
     * @var array
     */
    private $_locks = array();

    /**
     *
     */
    public function init()
    {
        parent::init();
        if (null === $this->mutexFile) {
            $this->mutexFile = Yii::app()->getRuntimePath() . '/mutex.bin';
        }
    }

    /**
     * @param $id
     * @param int $timeout
     * @return bool
     */
    public function lock($id, $timeout = 0)
    {
        $lockFileHandle = $this->_getLockFileHandle($id);
        if (flock($lockFileHandle, LOCK_EX)) {
            $data = @unserialize(@file_get_contents($this->mutexFile));
            if (empty($data)) {
                $data = array();
            }
            if (!isset($data[$id]) || ($data[$id][0] > 0 && $data[$id][0] + $data[$id][1] <= microtime(true))) {
                $data[$id] = array($timeout, microtime(true));
                array_push($this->_locks, $id);
                $result = (bool)file_put_contents($this->mutexFile, serialize($data));
            }
        }
        fclose($lockFileHandle);
        @unlink($this->_getLockFile($id));
        return isset($result) ? $result : false;
    }

    /**
     * @param null $id
     * @return bool
     * @throws CException
     */
    public function unlock($id = null)
    {
        if (null === $id && null === ($id = array_pop($this->_locks))) {
            throw new CException("No lock available that could be released. Make sure to setup a lock first.");
        }
        //elseif (in_array($id, $this->_locks))
        //{
        //    throw new CException("Don't define the id for a local lock. Only do it for locks that weren't created within the current request.");
        //}
        $lockFileHandle = $this->_getLockFileHandle($id);
        if (flock($lockFileHandle, LOCK_EX)) {
            $data = @unserialize(@file_get_contents($this->mutexFile));
            if (!empty($data) && isset($data[$id])) {
                unset($data[$id]);
                $result = (bool)file_put_contents($this->mutexFile, serialize($data));
            }
        }
        fclose($lockFileHandle);
        @unlink($this->_getLockFile($id));
        return isset($result) ? $result : false;
    }

    /**
     * @param $id
     * @return string
     */
    private function _getLockFile($id)
    {
        return "{$this->mutexFile}." . md5($id) . '.lock';
    }

    /**
     * @param $id
     * @return resource
     */
    private function _getLockFileHandle($id)
    {
        return fopen($this->_getLockFile($id), 'a+b');
    }

}

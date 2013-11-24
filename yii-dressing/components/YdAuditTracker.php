<?php
/**
 * YdAuditTracker
 *
 * @property int $id
 * @property YdAudit $audit
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.components
 */
class YdAuditTracker
{

    /**
     * @var YdAudit
     */
    private $_audit;

    /**
     *
     */
    public function init()
    {
        $this->getAudit();
    }


    /**
     * @return YdAudit
     */
    public function getAudit()
    {
        // get existing Audit
        if ($this->_audit)
            return $this->_audit;

        // create new Audit
        $this->_audit = new YdAudit();

        // cache not working so it could not get schema for audits
        if (!$this->_audit->attributes)
            return false;

        // add an event callback to update the audit at the end
        if ($this->recordAudit())
            Yii::app()->onEndRequest = array($this, 'endAudit');

        return $this->_audit;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_audit ? $this->_audit->id : 0;
    }

    /**
     *
     */
    private function recordAudit()
    {
        $audit = $this->getAudit();

        // get info
        $audit->created = date('Y-m-d H:i:s');
        $audit->user_id = Yii::app()->user->id;
        $audit->link = $this->getCurrentLink();
        $audit->start_time = YII_BEGIN_TIME;
        $audit->post = $_POST;
        $audit->get = $_GET;
        $audit->files = $_FILES;
        $audit->cookie = $_COOKIE;
        $audit->session = $this->getShrinkedSession();
        $audit->server = $_SERVER;
        $audit->ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
        $audit->referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;

        // remove passwords
        $passwordRemovedFromGet = $this->removedValuesWithPasswordKeys($audit->get = $audit->get);
        $passwordRemovedFromPost = $this->removedValuesWithPasswordKeys($audit->post = $audit->post);
        $this->removedValuesWithPasswordKeys($audit->server = $audit->server);
        if ($passwordRemovedFromGet || $passwordRemovedFromPost)
            $audit->server = null;
        if ($passwordRemovedFromGet)
            $audit->link = null;

        // pack all
        $audit->post = $audit->pack('post');
        $audit->get = $audit->pack('get');
        $audit->cookie = $audit->pack('cookie');
        $audit->server = $audit->pack('server');
        $audit->session = $audit->pack('session');
        $audit->files = $audit->pack('files');

        // save
        return $audit->save(false);
    }

    /**
     *
     */
    public function endAudit()
    {
        $audit = $this->getAudit();
        $headers = headers_list();
        foreach ($headers as $header) {
            if (strpos(strtolower($header), 'location:') === 0) {
                $audit->redirect = trim(substr($header, 9));
            }
        }
        $audit->memory_usage = memory_get_usage();
        $audit->memory_peak = memory_get_peak_usage();
        $audit->end_time = microtime(true);
        $audit->audit_trail_count = $audit->auditTrailCount;
        $audit->total_time = $audit->end_time - $audit->start_time;
        $audit->save(false);
    }

    /**
     * @return string
     */
    private function getCurrentLink()
    {
        if (Yii::app() instanceof CWebApplication) {
            return Yii::app()->getRequest()->getHostInfo() . Yii::app()->getRequest()->getUrl();
        }
        $link = 'yiic ';
        if (isset($_SERVER['argv'])) {
            $argv = $_SERVER['argv'];
            array_shift($argv);
            $link .= implode(' ', $argv);
        }
        return trim($link);
    }


    /**
     * @static
     * @param $array
     * @return bool
     */
    private function removedValuesWithPasswordKeys(&$array)
    {
        if (!$array) {
            return false;
        }
        $removed = false;
        foreach ($array as $key => $value) {
            if (stripos($key, 'password') !== false) {
                $array[$key] = 'Possible password removed';
                $removed = true;
            }
            elseif (stripos($key, 'PHP_AUTH_PW') !== false) {
                $array[$key] = 'Possible password removed';
                $removed = true;
            }
            else {
                if (is_array($value)) {
                    $removedChild = $this->removedValuesWithPasswordKeys($value);
                    if ($removedChild) {
                        $array[$key] = $value;
                        $removed = true;
                    }
                }
            }
        }
        return $removed;
    }


    /**
     * @return mixed
     */
    public function getShrinkedSession()
    {
        $serialized = '';
        if (isset($_SESSION)) {
            $serialized = serialize($_SESSION);
        }
        if (strlen($serialized) > 64000) {
            $sessionCopy = $_SESSION;
            $ignoredKeys = array();
            foreach ($_SESSION as $key => $value) {
                $size = strlen(serialize($value));
                if ($size > 1000) {
                    unset($sessionCopy[$key]);
                    $ignoredKeys[$key] = $key;
                }
            }
            $sessionCopy['__ignored_keys_in_audit'] = $ignoredKeys;
            $serialized = serialize($sessionCopy);
        }
        return unserialize($serialized);
    }


}
<?php

/**
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'audit'
 *
 * @method YdAudit with() with()
 * @method YdAudit find() find($condition, array $params = array())
 * @method YdAudit[] findAll() findAll($condition = '', array $params = array())
 * @method YdAudit findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method YdAudit[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method YdAudit findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdAudit[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdAudit findBySql() findBySql($sql, array $params = array())
 * @method YdAudit[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Properties from relation
 * @property YdUser $user
 * @property YdAuditTrail[] $auditTrail
 * @property integer $auditTrailCount
 *
 * Properties from table fields
 * @property integer $id
 * @property string $link
 * @property integer $user_id
 * @property string $ip
 * @property string $post
 * @property string $get
 * @property string $files
 * @property string $session
 * @property string $server
 * @property string $cookie
 * @property string $referrer
 * @property string $redirect
 * @property string $app_version
 * @property string $yii_version
 * @property integer $audit_trail_count
 * @property number $start_time
 * @property number $end_time
 * @property number $total_time
 * @property integer $memory_usage
 * @property integer $memory_peak
 * @property datetime $created
 * @property integer $preserve
 *
 * --- END GenerateProperties ---
 */
class YdAudit extends YdActiveRecord
{

    /**
     * @var
     */
    public $model;

    /**
     * @var
     */
    public $model_id;

    /**
     * @var
     */
    public $get;

    /**
     * @var
     */
    public $post;

    /**
     * @var
     */
    public $server;

    /**
     * @var bool
     */
    public $ignoreClearCache = true;

    /**
     * @var
     */
    static private $_audit;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return Audit the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('id, user_id, link, ip, created, app_version, yii_version, audit_trail_count, total_time, memory_usage, memory_peak, model, model_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(
                self::BELONGS_TO,
                'YdUser',
                'user_id',
            ),
            'auditTrail' => array(
                self::HAS_MANY,
                'YdAuditTrail',
                'audit_id',
            ),
            'auditTrailCount' => array(
                self::STAT,
                'YdAuditTrail',
                'audit_id',
            ),
        );
    }

    /**
     * @return string
     */
    public function getLinkString()
    {
        $link = $this->link;
        $path = Yii::app()->getRequest()->getHostInfo() . Yii::app()->request->baseUrl;
        if (strpos($link, $path) === 0) {
            $link = substr($link, strlen($path));
        }
        if (strlen($link) < 64)
            return $link;
        return substr($link, 0, 64) . '...';
    }

    /**
     * @static
     * @param $linkGiven
     * @return string
     */
    static function reverseLinkString($linkGiven)
    {
        if (strpos($linkGiven, '/') === 0) {
            $path = Yii::app()->getRequest()->getHostInfo() . Yii::app()->request->baseUrl;
            $result = $path . $linkGiven;
            return $result;
        }
        else {
            return $linkGiven;
        }
    }

    /**
     *
     */
    public function recordAudit()
    {
        // get info
        $this->created = date('Y-m-d H:i:s');
        $this->user_id = Yii::app()->user->id;
        $this->link = $this->getCurrentLink();
        $this->app_version = YdSetting::item('app_version');
        $this->yii_version = YdSetting::item('yii_version');
        $this->start_time = $_ENV['_start'];
        $this->post = $_POST;
        $this->get = $_GET;
        $this->files = $_FILES;
        $this->cookie = $_COOKIE;
        $this->session = $this->getShrinkedSession();
        $this->server = $_SERVER;
        $this->ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
        $this->referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;

        // remove passwords
        $passwordRemovedFromGet = self::removedValuesWithPasswordKeys($this->get);
        $passwordRemovedFromPost = self::removedValuesWithPasswordKeys($this->post);
        self::removedValuesWithPasswordKeys($this->server);
        if ($passwordRemovedFromGet || $passwordRemovedFromPost) {
            $this->server = null;
        }
        if ($passwordRemovedFromGet) {
            $this->link = null;
        }

        // pack all
        $this->post = $this->pack('post');
        $this->get = $this->pack('get');
        $this->cookie = $this->pack('cookie');
        $this->server = $this->pack('server');
        $this->session = $this->pack('session');
        $this->files = $this->pack('files');

        // save
        return $this->save();
    }

    /**
     * @return string
     */
    public function getCurrentLink()
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
     * @param $attribute
     * @return string
     */
    public function pack($attribute)
    {
        $value = $this->$attribute;
        //already packed
        @$alreadyDecoded = is_array(unserialize(gzuncompress(base64_decode($value))));
        if ($alreadyDecoded) {
            echo "<br/> already decoded  <br/>\r\n";
            return;
        }
        $value = serialize($value);
        $value = gzcompress($value);
        $value = base64_encode($value);
        return $value;
    }

    /**
     * @param $attribute
     * @return mixed
     */
    public function unpack($attribute)
    {
        @$value = unserialize($this->$attribute);
        if ($value !== false) {
            $this->$attribute = $value;
            return false;
        }
        $value = base64_decode($this->$attribute);
        if (!$value) {
            return false;
        }

        @$value = gzuncompress($value);
        if ($value === false) {
            $this->$attribute = "could not uncompress [" . var_dump($value) . "]";
            return false;
        }
        @$value = unserialize($value);
        if ($value === false) {
            $this->$attribute = "could not unserialize [" . var_dump($value) . "]";
        }
        return $value;
    }

    /**
     * @static
     * @param $array
     * @return bool
     */
    static function removedValuesWithPasswordKeys(&$array)
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
                    $removedChild = self::removedValuesWithPasswordKeys($value);
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
     *
     */
    protected function updateAudit()
    {
        $headers = headers_list();
        foreach ($headers as $header) {
            if (strpos(strtolower($header), 'location:') === 0) {
                $this->redirect = trim(substr($header, 9));
            }
        }
        $this->memory_usage = memory_get_usage();
        $this->memory_peak = memory_get_peak_usage();
        $this->end_time = microtime(true);
        $this->audit_trail_count = $this->auditTrailCount;
        $this->total_time = $this->end_time - $this->start_time;
        $this->save();
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


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param array $options
     * @return YdActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($options = array())
    {
        $criteria = new CDbCriteria;
        if (strpos($this->id, 'range ') !== false) {
            $id = trim(str_replace('range ', '', $this->id));
            list($start, $end) = explode('-', $id);
            $criteria->addBetweenCondition('t.id', trim($start), trim($end));
        }
        else {
            $criteria->compare('t.id', $this->id);
        }

        $criteria->compare('t.user_id', $this->user_id);
        if (YdHelper::getSubmittedField('limit') != 'ignore') {
            $date = date('Y-m-d', strtotime('-15 days'));
            $criteria->compare('t.created', ' > ' . $date);
            $criteria->compare('t.user_id', '<> ""');

            // ignore system users
            //$lcdUserCriteria = new CDbCriteria();
            //$lcdUserCriteria->compare('u2r.role_id', Role::ROLE_LCD, true);
            //$lcdUserCriteria->join .= ' LEFT JOIN user_to_role u2r ON u2r.user_id=t.id AND u2r.role_id=:role_id';
            //$lcdUserCriteria->params[':role_id'] = Role::ROLE_LCD;
            //$lcdUsers = User::model()->findAll($lcdUserCriteria);
            //foreach ($lcdUsers as $lcdUser) {
            //    $criteria->addCondition('t.user_id != ' . $lcdUser->id);
            //}
        }
        $criteria->compare('t.created', $this->created);
        $criteria->compare('t.link', $this->link, true);

        $criteria->compare('t.app_version', $this->app_version);
        $criteria->compare('t.yii_version', $this->yii_version);
        $criteria->compare('t.audit_trail_count', $this->audit_trail_count);
        $criteria->compare('t.total_time', $this->total_time);
        $criteria->compare('t.memory_usage', $this->memory_usage);
        $criteria->compare('t.memory_peak', $this->memory_peak);
        $criteria->mergeWith($this->getDbCriteria());

        if ($this->model) {
            $criteria->distinct = true;
            $criteria->compare('t.audit_trail_count', '>0');
            //$criteria->group = 't.id';
            $criteria->join .= ' INNER JOIN audit_trail ON audit_trail.audit_id=t.id ';
            $criteria->compare('audit_trail.model', $this->model);
            if ($this->model_id) {
                $criteria->compare('audit_trail.model_id', $this->model_id);
            }
        }

        return new YdActiveDataProvider(get_class($this), CMap::mergeArray(array(
            'criteria' => $criteria,
        ), $options));
    }

    /**
     * @return string
     */
    public function showYiiVersion()
    {
        $startPos = strpos($this->yii_version, 'yii-');
        $endPos = strpos($this->yii_version, '.r', $startPos);
        $len = $endPos - $startPos;
        $shortVersion = substr($this->yii_version, $startPos, $len);
        $shortVersion = substr($shortVersion, 4);
        $icon = CHtml::link('<i class="icon-comment"></i>', 'javascript:void();', array('title' => $this->yii_version));
        return $icon . '&nbsp;' . $shortVersion;
    }


    /**
     * @return bool|string
     */
    public function showAppVersion()
    {
        return CHtml::link('<i class="icon-comment"></i>', 'javascript:void();', array('title' => $this->app_version));
    }

    /**
     * @return Audit
     */
    static public function findCurrent()
    {
        if (!YdSetting::item('audit')) {
            return false;
        }

        // get existing Audit
        if (self::$_audit) {
            return self::$_audit;
        }

        // create new Audit
        self::$_audit = new Audit();
        //cache not working so it could not get schema for audits
        if (!self::$_audit->attributes) {
            return false;
        }
        if (self::$_audit->recordAudit()) {
            Yii::app()->onEndRequest = array(self::$_audit, 'updateAudit');
        }
        return self::$_audit;
    }

    /**
     * @return int|bool
     */
    static public function findCurrentId()
    {
        if (!YdSetting::item('audit')) {
            return false;
        }

        if (self::$_audit) {
            return self::$_audit->id;
        }
        $audit = self::findCurrent();
        if ($audit) {
            return $audit->id;
        }
        return false;
    }


}
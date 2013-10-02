<?php

/**
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'token'
 *
 * @method YdToken with() with()
 * @method YdToken find() find($condition, array $params = array())
 * @method YdToken[] findAll() findAll($condition = '', array $params = array())
 * @method YdToken findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method YdToken[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method YdToken findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdToken[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdToken findBySql() findBySql($sql, array $params = array())
 * @method YdToken[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Properties from table fields
 * @property integer $id
 * @property string $token
 * @property string $model
 * @property integer $model_id
 * @property integer $uses_allowed
 * @property integer $uses_remaining
 * @property datetime $expires
 * @property datetime $created
 *
 * --- END GenerateProperties ---
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */
class YdToken extends YdActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return YdToken the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array containing model behaviors
     */
    public function behaviors()
    {
        return array(
            'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('dressing', 'ID'),
        );
    }

    /**
     * @param $expires
     * @param $uses_allowed
     * @param $relation
     * @return string
     */
    public function add($expires, $uses_allowed, $relation)
    {
        $plain = md5($this->hashToken(uniqid(true)));
        $token = new YdToken();
        $token->uses_allowed = $uses_allowed;
        $token->uses_remaining = $uses_allowed;
        $token->expires = YdTime::datetime($expires);
        $token->model = !empty($relation['model']) ? $relation['model'] : '';
        $token->model_id = !empty($relation['model_id']) ? $relation['model_id'] : '';
        $token->token = $this->hashToken($plain);
        $token->created = date('Y-m-d H:i:s');
        $token->save();
        return $plain;
    }

    /**
     * @param $model
     * @param $model_id
     * @param $plain
     * @return YdToken
     */
    public function checkToken($model, $model_id, $plain)
    {
        // check for valid token
        $token = self::model()->find("model=:model AND model_id=:model_id ORDER BY t.created DESC, t.id DESC", array(
            ':model' => $model,
            ':model_id' => $model_id,
        ));
        if (!$token) {
            $this->addError('token', Yii::t('dressing', 'missing token'));
            return false;
        }
        // check uses remaining
        if ($token->uses_remaining <= 0) {
            $this->addError('token', Yii::t('dressing', 'no uses remaining'));
            return false;
        }
        // check expires
        if (strtotime($token->expires) <= time()) {
            $this->addError('token', Yii::t('dressing', 'token has expired'));
            return false;
        }
        // check token plain
        if (!$token->validateToken($plain)) {
            $this->addError('token', Yii::t('dressing', 'token is invalid'));
            return false;
        }
        return $token;
    }

    /**
     * @param $model
     * @param $model_id
     * @param $plain
     * @return bool
     */
    public function useToken($model, $model_id, $plain)
    {
        $token = $this->checkToken($model, $model_id, $plain);
        if (!$token) {
            return false;
        }
        // deduct from uses remaining
        $token->uses_remaining--;
        $token->save(false);
        return true;
    }

    /**
     * @param $plain
     * @param null $encrypted
     * @return boolean validates a token
     */
    public function validateToken($plain, $encrypted = null)
    {
        $encrypted = $encrypted ? $encrypted : $this->token;
        if (!$plain || !$encrypted) {
            return false;
        }
        $ph = new YdPasswordHash(8, false);
        return $ph->CheckPassword($plain, $encrypted);
    }

    /**
     * @param $plain
     * @return string creates a token hash
     */
    public function hashToken($plain)
    {
        $ph = new YdPasswordHash(8, false);
        return $ph->HashPassword($plain);
    }

}
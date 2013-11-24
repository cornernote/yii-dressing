<?php
Yii::import('zii.behaviors.CTimestampBehavior');

/**
 * YdTimestampBehavior automatically detects the created and updated fields and populates them when the model is saved.
 *
 * @property ActiveRecord $owner
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.behaviors
 */
class YdTimestampBehavior extends CTimestampBehavior
{

    /**
     * @var bool True to attempt to detect the fields to use for created and updated.
     */
    public $autoColumns = true;

    /**
     * @var array Contains any fields that may be used to store the created timestamp.
     */
    public $createAttributes = array('created', 'create_time', 'created_at');

    /**
     * @var array Contains any fields that may be used to store the updated timestamp.
     */
    public $updateAttributes = array('updated', 'update_time', 'updated_at');

    /**
     * Responds to {@link CModel::onBeforeSave} event.
     * Decides if there are created/updated fields then calls parent to update them.
     *
     * @param CModelEvent $event event parameter
     */
    public function beforeSave($event)
    {
        $this->_setAttributes();
        parent::beforeSave($event);
    }

    /**
     * Decides if there are created/updated fields and sets them to be used
     */
    private function _setAttributes()
    {
        if (!$this->autoColumns)
            return;
        $this->autoColumns = false;
        $this->createAttribute = $this->_getAttribute($this->createAttributes);
        $this->updateAttribute = $this->_getAttribute($this->updateAttributes);
    }

    /**
     * Checks the table to see if a matching field exists
     * @param array $attributes fields to check for
     * @return bool|string
     */
    private function _getAttribute($attributes)
    {
        foreach ($attributes as $attribute)
            if (in_array($attribute, $this->owner->tableSchema->columnNames))
                return $attribute;
        return false;
    }

}

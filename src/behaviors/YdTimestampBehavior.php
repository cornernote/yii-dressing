<?php
Yii::import('zii.behaviors.CTimestampBehavior');

/**
 * YdTimestampBehavior
 *
 * @property ActiveRecord $owner
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */
class YdTimestampBehavior extends CTimestampBehavior
{

    /**
     * @var bool
     */
    public $autoColumns = true;

    /**
     * @var mixed The name of the attribute to store the creation time.  Set to null to not
     * use a timestamp for the creation attribute.
     */
    public $createAttribute;

    /**
     * @var mixed The name of the attribute to store the modification time.  Set to null to not
     * use a timestamp for the update attribute.
     */
    public $updateAttribute;

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

        $columnNames = $this->owner->tableSchema->columnNames;
        if (in_array('created', $columnNames)) {
            $this->createAttribute = 'created';
        }
        if (in_array('updated', $columnNames)) {
            $this->updateAttribute = 'updated';
        }
    }

}

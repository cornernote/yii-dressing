<?php
/**
 * YdSoftDeleteBehavior
 *
 * @package components.behaviors
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class YdSoftDeleteBehavior extends CActiveRecordBehavior
{
    /**
     * @var string
     */
    public $deleted = 'deleted';
    /**
     * @var string
     */
    public $deletedBy = 'deleted_by';

    /**
     * @param CModelEvent $event
     */
    public function beforeDelete($event)
    {
        if (isset($this->owner->tableSchema->columns[$this->deleted])) {
            $this->owner->{$this->deleted} = date('Y-m-d H:i:s');
        }
        if (isset($this->owner->tableSchema->columns[$this->deletedBy])) {
            $this->owner->{$this->deletedBy} = Yii::app()->user->id;
        }
        $this->owner->save(false);

        //prevent real deletion
        $event->isValid = false;
    }

    /**
     * @return mixed
     * @throws CDbException
     */
    public function undelete()
    {
        if (!$this->owner->isNewRecord) {
            Yii::trace(get_class($this) . '.undelete()', 'system.db.ar.CActiveRecord');
            $updateFields = array(
                $this->deleted => null,
            );
            return $this->owner->updateByPk($this->owner->getPrimaryKey(), $updateFields);
        }
        else
            throw new CDbException(Yii::t('yii', 'The active record cannot be undeleted because it is new.'));
    }

    /**
     * @return mixed
     */
    public function deleteds()
    {
        $this->owner->dbCriteria->mergeWith(array(
            'condition' => $this->deleted . ' IS NOT NULL'
        ));
        return $this->owner;
    }

    /**
     * @return mixed
     */
    public function notdeleteds()
    {
        $this->owner->dbCriteria->mergeWith(array(
            'condition' => $this->deleted . ' IS NULL'
        ));
        return $this->owner;
    }

}
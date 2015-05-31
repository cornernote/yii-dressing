<?php

/**
 * YdSoftDeleteBehavior automatically sets a deleted field to the date instead of deleting the row from the database.
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.behaviors
 */
class YdSoftDeleteBehavior extends CActiveRecordBehavior
{
    /**
     * The field to use to store the deleted date.
     * @var string
     */
    public $deleted = 'deleted';

    /**
     * The field to use to store the user who deleted the row.
     * @var string
     */
    public $deletedBy = 'deleted_by';

    /**
     * Override the default delete to update the deleted field instead of deleting the row from the database.
     * @param CModelEvent $event
     */
    public function beforeDelete($event)
    {
        if ($this->deleted && isset($this->owner->tableSchema->columns[$this->deleted])) {
            $this->owner->{$this->deleted} = date('Y-m-d H:i:s');
        }
        if ($this->deletedBy && isset($this->owner->tableSchema->columns[$this->deletedBy])) {
            $this->owner->{$this->deletedBy} = Yii::app()->user->id;
        }
        $this->owner->save(false);

        //prevent real deletion
        $event->isValid = false;
    }

    /**
     * Method available to the model to perform an undelete.
     * @return mixed
     * @throws CDbException
     */
    public function undelete()
    {
        if (!$this->owner->isNewRecord) {
            $this->owner->setAttribute($this->deleted, null);
            return $this->owner->save(false);
        }
        return false;
    }

    /**
     * Method available to the model to help finding deleted records.
     *
     * eg:
     * <pre>
     * Model::model()->deleteds()->findAll();
     * </pre>
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
     * Method available to the model to help excluding deleted records from the results.
     *
     * eg:
     * <pre>
     * Model::model()->notDeleteds()->findAll();
     * </pre>
     * @return mixed
     */
    public function notDeleteds()
    {
        $this->owner->dbCriteria->mergeWith(array(
            'condition' => $this->deleted . ' IS NULL'
        ));
        return $this->owner;
    }

}
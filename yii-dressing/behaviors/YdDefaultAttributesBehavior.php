<?php
/**
 * YdDefaultAttributesBehavior automatically calls setDefaultAttributes() on your model on beforeValidate() and beforeSave().
 *
 * @property YdActiveRecord $owner
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.behaviors
 */
class YdDefaultAttributesBehavior extends CActiveRecordBehavior
{

    /**
     * Allows setting default attributes before validation and saving in a single method.
     *
     * @see beforeValidate()
     * @see beforeSave()
     */
    public function setDefaultAttributes()
    {
    }

    /**
     * @param CModelEvent $event
     */
    protected function beforeValidate($event)
    {
        $this->getOwner()->setDefaultAttributes();
        return parent::beforeValidate($event);
    }

    /**
     * @param CModelEvent $event
     */
    protected function beforeSave($event)
    {
        $this->getOwner()->setDefaultAttributes();
        return parent::beforeSave($event);
    }

}

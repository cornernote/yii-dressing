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
     * Should not be called directly.
     *
     * The setDefaultAttributes method must be defined in the owner model.  It will allows setting default
     * attributes before validation and saving from a central method.
     *
     * @see beforeValidate()
     * @see beforeSave()
     * @throws CException if you have not defined setDefaultAttributes in the owner model.
     */
    public function setDefaultAttributes()
    {
        throw new CException(Yii::t('dressing', 'The setDefaultAttributes method must be defined in :class', array(
            'class' => get_class($this->getOwner()),
        )));
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

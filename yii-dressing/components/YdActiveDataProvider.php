<?php
/**
 * YdActiveDataProvider
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdActiveDataProvider extends CActiveDataProvider
{
    /**
     * @return CSort
     */
    public function getSort($className = 'CSort')
    {
        if (($sort = parent::getSort($className)) !== false) {
            if (!$sort->defaultOrder) {
                $sort->modelClass = $this->modelClass;
                $sort->multiSort = true;
                $pk = $this->model->getMetaData()->tableSchema->primaryKey;
                if ($pk && !is_array($pk)) {
                    $sort->defaultOrder = 't.' . $pk . ' DESC';
                }
            }
        }
        return $sort;
    }
}

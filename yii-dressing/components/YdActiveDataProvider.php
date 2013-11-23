<?php
/**
 * YdActiveDataProvider
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.components
 */
class YdActiveDataProvider extends CActiveDataProvider
{
    /**
     * @return CSort
     */
    public function getSort()
    {
        if (($sort = parent::getSort()) !== false) {
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
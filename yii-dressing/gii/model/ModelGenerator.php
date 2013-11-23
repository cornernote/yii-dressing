<?php

/**
 * Class ModelGenerator
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */
class ModelGenerator extends CCodeGenerator
{
    /**
     * @var string
     */
    public $codeModel = 'dressing.gii.model.ModelCode';

    /**
     * Provides autocomplete table names
     * @param string $db the database connection component id
     * @throws CHttpException
     * @return string the json array of tablenames that contains the entered term $q
     */
    public function actionGetTableNames($db)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $all = array();
            if (!empty($db) && Yii::app()->hasComponent($db) !== false && (Yii::app()->getComponent($db) instanceof CDbConnection))
                $all = array_keys(Yii::app()->{$db}->schema->getTables());

            echo json_encode($all);
        }
        else
            throw new CHttpException(404, 'The requested page does not exist.');
    }
}
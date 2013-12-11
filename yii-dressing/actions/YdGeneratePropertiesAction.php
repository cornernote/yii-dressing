<?php

/**
 * YdGeneratePropertiesAction allows you to update model files to contain correct phpdoc definitions regarding fields,
 * relations and behaviors.
 *
 * YdGeneratePropertiesAction can be added as an action to any controller:
 * <pre>
 * class ToolController extends YdWebController
 * {
 *     public function actions()
 *     {
 *         return array(
 *             'generateProperties' => array(
 *                 'class' => 'dressing.actions.YdGeneratePropertiesAction',
 *             ),
 *         );
 *     }
 * }
 * </pre>
 *
 * @property YdWebController $controller
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 *
 * @package dressing.actions
 */
class YdGeneratePropertiesAction extends CAction
{

    /**
     * @var
     */
    public $modelName;

    /**
     * @var CActiveRecord
     */
    public $model;

    /**
     * Runs the action.
     * This method displays the view requested by the user.
     * @throws CHttpException if the modelName is invalid
     */
    public function run($modelName = null)
    {
        // build all
        if ($modelName == 'confirm_all') {
            $this->replaceAllModelProperties();
            $modelName = null;
        }

        // show a list
        if (!$modelName) {
            $this->renderModelList();
            return;
        }

        // render the properties
        $this->renderModelProperties($modelName);
    }

    /**
     *
     */
    public function renderModelList()
    {
        //ob_start();
        //$this->controller->widget('bootstrap.widgets.TbMenu', array(
        //    'type' => 'pills', // '', 'tabs', 'pills' (or 'list')
        //    //'stacked' => true, // whether this is a stacked menu
        //    'items' => $this->getModelList(),
        //));
        //$contents = ob_get_clean();
        $this->controller->pageHeading = $this->controller->pageTitle = Yii::t('dressing', 'Generate Model Properties');
        $this->controller->menu = $this->getModelList();
        $this->controller->renderText(CHtml::link(Yii::t('dressing', 'Replace All Model Properties'), array('/' . $this->controller->id . '/' . $this->controller->action->id, 'modelName' => 'confirm_all'), array('class' => 'btn btn-primary btn-large')));
    }

    /**
     * @return array
     */
    public function getModelList()
    {
        $pathList = CFileHelper::findFiles(Yii::getPathOfAlias("application.models"), array('fileTypes' => array('php')));
        $modelList = array();
        foreach ($pathList as $path) {
            $modelName = basename($path, '.php');
            if (strpos($modelName, '.') !== false) {
                echo "<br/> there is dot in modelName [$modelName] probably a version conflict file <br/>\r\n";
                continue;
            }
            $model = new $modelName;
            if ($model && is_subclass_of($model, 'CActiveRecord')) {
                $modelList[] = array('label' => $modelName, 'url' => array('/' . $this->controller->id . '/' . $this->controller->action->id, 'modelName' => $modelName));
            }
        }
        return $modelList;
    }

    /**
     * @param $modelName string
     */
    public function renderModelProperties($modelName)
    {
        $properties = $this->getModelProperties($modelName);
        $message = $this->replaceModelProperties($modelName, $properties);
        $this->controller->addBreadcrumb(Yii::t('dressing', 'Generate Properties'), array('/tool/generateProperties'));
        $this->controller->pageTitle = $modelName;
        $this->controller->menu = $this->getModelList();
        $this->controller->renderText($message . '<pre>' . implode("\n", $properties) . '</pre>');
    }

    /**
     *
     */
    public function replaceAllModelProperties()
    {
        foreach ($this->getModelList() as $modelInfo) {
            $modelName = $modelInfo['label'];
            $properties = $this->getModelProperties($modelName);
            $this->replaceModelProperties($modelName, $properties);
        }
        $this->controller->addBreadcrumb(Yii::t('dressing', 'Generate Properties'), array('/tool/generateProperties'));
        $this->controller->pageTitle = Yii::t('dressing', 'Replace All Model Properties');
        $this->controller->menu = $this->getModelList();
        $this->controller->renderText(Yii::t('dressing', 'Done!'));
    }

    /**
     * @param $modelName string
     * @param $properties array
     * @return string
     */
    public function replaceModelProperties($modelName, $properties)
    {
        $begin = " * --- BEGIN GenerateProperties ---";
        $end = " * --- END GenerateProperties ---";
        $contents = $begin . "\n" . implode("\n", $properties) . "\n" . $end;

        $fileName = Yii::getPathOfAlias("application.models") . '/' . $modelName . '.php';
        if (!file_exists($fileName)) {
            $fileName = Yii::getPathOfAlias("application.models.cre") . '/' . $modelName . '.php';
        }
        if (file_exists($fileName)) {
            $fileContents = file_get_contents($fileName);
            $fileContents = strtr($fileContents, array(
                ' * --- BEGIN AutoGenerated by tool/generateProperties ---' => $begin,
                ' * --- END AutoGenerated by tool/generateProperties ---' => $end,
            ));
            $firstPos = strpos($fileContents, $begin);
            $lastPos = strpos($fileContents, $end);
            if ($firstPos && $lastPos && ($lastPos > $firstPos)) {
                $oldDoc = YdStringHelper::getBetweenString($fileContents, $begin, $end, false, false);
                if ($contents != $oldDoc) {
                    file_put_contents($fileName, str_replace($oldDoc, $contents, $fileContents));
                    return 'overwrote file: ' . realpath($fileName);
                }
                else {
                    return 'contents matches file: ' . realpath($fileName);
                }
            }
        }
        return '';
    }

    /**
     * @param $modelName
     * @throws CHttpException
     * @return array
     */
    public function getModelProperties($modelName)
    {
        $properties = array(' *');

        // load the model
        $model = CActiveRecord::model($modelName);
        if (!$model) {
            throw new CHttpException(strtr(Yii::t('dressing', 'No CActiveRecord Class with name :modelName was not found.'), array(':modelName' => $modelName)));
        }

        Yii::app()->db->getSchema()->refresh();
        $model->refreshMetaData();
        //$model->refresh(); // caused an error on many_to_many tables

        // get own methods and properties
        $reflection = new ReflectionClass($modelName);
        $selfMethods = CHtml::listData($reflection->getMethods(), 'name', 'name');
        $selfProperties = CHtml::listData($reflection->getProperties(), 'name', 'name');

        // table fields
        $properties[] = ' * Properties from table ' . $model->tableName();
        foreach ($model->tableSchema->columns as $column) {
            $type = $column->type;
            if (($column->dbType == 'datetime') || ($column->dbType == 'date')) {
                $type = 'string'; // $column->dbType;
            }
            if (strpos($column->dbType, 'decimal') !== false) {
                $type = 'number';
            }
            $properties[] = ' * @property ' . $type . ' $' . $column->name;
        }
        $properties[] = ' *';

        // relations
        $relations = $model->relations();
        if ($relations) {
            $properties[] = ' * Properties from relations';
            foreach ($relations as $relationName => $relation) {
                if (in_array($relation[0], array('CBelongsToRelation', 'CHasOneRelation')))
                    $properties[] = ' * @property ' . $relation[1] . ' $' . $relationName;

                elseif (in_array($relation[0], array('CHasManyRelation', 'CManyManyRelation')))
                    $properties[] = ' * @property ' . $relation[1] . '[] $' . $relationName;

                elseif (in_array($relation[0], array('CStatRelation')))
                    $properties[] = ' * @property integer $' . $relationName;

                else
                    $properties[] = ' * @property unknown $' . $relationName;
            }
            $properties[] = ' *';
        }

        // active record
        $properties[] = ' * Methods from CActiveRecord';
        $properties[] = " * @method {$modelName} model() static model(string \$className = NULL)";
        $properties[] = " * @method {$modelName} with() with()";
        $properties[] = " * @method {$modelName} find() find(\$condition, array \$params = array())";
        $properties[] = " * @method {$modelName}[] findAll() findAll(\$condition = '', array \$params = array())";
        $properties[] = " * @method {$modelName} findByPk() findByPk(\$pk, \$condition = '', array \$params = array())";
        $properties[] = " * @method {$modelName}[] findAllByPk() findAllByPk(\$pk, \$condition = '', array \$params = array())";
        $properties[] = " * @method {$modelName} findByAttributes() findByAttributes(array \$attributes, \$condition = '', array \$params = array())";
        $properties[] = " * @method {$modelName}[] findAllByAttributes() findAllByAttributes(array \$attributes, \$condition = '', array \$params = array())";
        $properties[] = " * @method {$modelName} findBySql() findBySql(\$sql, array \$params = array())";
        $properties[] = " * @method {$modelName}[] findAllBySql() findAllBySql(\$sql, array \$params = array())";
        $properties[] = " *";

        // behaviors
        $behaviors = $model->behaviors();
        if ($behaviors) {
            $behaviorMethods = array();
            foreach (get_class_methods('CActiveRecordBehavior') as $methodName)
                $behaviorMethods[$methodName] = $methodName;
            $behaviorProperties = array();
            foreach (get_class_vars('CActiveRecordBehavior') as $propertyName)
                $behaviorProperties[$propertyName] = $propertyName;

            foreach ($behaviors as $behavior) {
                $behavior = $this->getBehaviorClass($behavior);
                $behaviorProperties = $this->getBehaviorProperties($behavior, CMap::mergeArray($behaviorMethods, $selfMethods), CMap::mergeArray($behaviorProperties, $selfProperties));
                if ($behaviorProperties) {
                    $properties[] = ' * Methods from behavior ' . $behavior;
                    foreach ($behaviorProperties as $behaviorProperty) {
                        $properties[] = $behaviorProperty;
                    }
                    $properties[] = ' *';
                }
            }
        }

        // all done...
        return $properties;
    }

    /**
     * @param $behavior
     * @return mixed
     */
    public function getBehaviorClass($behavior)
    {
        if (is_array($behavior))
            $behavior = $behavior['class'];
        $behavior = explode('.', $behavior);
        return $behavior[count($behavior) - 1];
    }

    /**
     * @param $behavior
     * @param array $ignoreMethods
     * @param array $ignoreProperties
     * @return array
     */
    public function getBehaviorProperties($behavior, $ignoreMethods = array(), $ignoreProperties = array())
    {
        $properties = array();

        //// properties
        //foreach (get_class_vars($behavior) as $propertyName => $default) {
        //    if (isset($ignoreProperties[$propertyName]))
        //        continue;
        //    $properties[] = ' * @property ' . gettype($default) . ' $' . $propertyName;
        //}

        // methods
        foreach (get_class_methods($behavior) as $methodName) {
            if (isset($ignoreMethods[$methodName]))
                continue;
            $methodReturn = $this->getTypeFromDocComment($behavior, $methodName, 'return');
            $paramTypes = $this->getDocComment($behavior, $methodName, 'param');
            $methodReturn = $methodReturn ? current($methodReturn) . ' ' : '';
            $property = " * @method $methodReturn$methodName() $methodName(";
            $r = new ReflectionMethod($behavior, $methodName);
            $params = $r->getParameters();
            $separator = '';
            foreach ($params as $param) {
                //$param is an instance of ReflectionParameter
                /* @var $param ReflectionParameter */
                $type = current($paramTypes);
                $filterType = '';
                if ($type && strpos($type, '$')) {
                    $typeString = YdStringHelper::getBetweenString($type, false, '$');
                    $typeString = trim($typeString);
                    $filterType = $this->filterDocType($typeString);
                    $filterType = $filterType ? trim($filterType) . ' ' : '';
                }
                next($paramTypes);
                $property .= $separator . $filterType . '$' . $param->getName();
                if ($param->isOptional()) {
                    $property .= ' = ';
                    $property .= strtr(str_replace("\n", '', var_export($param->getDefaultValue(), true)), array(
                        'array (' => 'array(',
                    ));
                }
                $separator = ', ';
            }
            $property .= ")";
            $properties[] = $property;

        }

        return $properties;
    }

    /**
     * @param $class
     * @param $method
     * @param string $tag
     * @return array|string
     */
    public function getDocComment($class, $method, $tag = '')
    {
        $reflection = new ReflectionMethod($class, $method);
        $comment = $reflection->getDocComment();
        if (!$tag) {
            return $comment;
        }

        $matches = array();
        preg_match_all("/@" . $tag . " (.*)(\\r\\n|\\r|\\n)/U", $comment, $matches);

        $returns = array();
        foreach ($matches[1] as $match) {
            $match = explode(' ', $match);
            $type = $match[0];
            $name = isset($match[1]) ? $match[1] : '';
            if (strpos($type, '$') === 0) {
                $name_ = $name;
                $name = $type;
                $type = $name_;
            }
            if (strpos($name, '$') !== 0) {
                $name = '';
            }
            $returns[] = trim($type . ' ' . $name);
        }

        return $returns;
    }

    /**
     * @param $class
     * @param $method
     * @param $tag
     * @return array
     */
    public function getTypeFromDocComment($class, $method, $tag)
    {
        $types = $this->getDocComment($class, $method, $tag);
        $returnTypes = array();
        foreach ($types as $k => $type) {
            $filteredType = $this->filterDocType($type);
            if ($filteredType) {
                $returnTypes[$k] = trim($filteredType);
            }
        }
        return $returnTypes;

    }

    /**
     * @param $type
     * @return mixed|string
     */
    public function filterDocType($type)
    {
        $ignoreTypes = array('void', 'mixed', 'null');
        $replace = array(
            'bool' => 'boolean',
            'integer' => 'int',
        );
        $filteredType = '';
        if (strpos($type, '|') !== false) {
            $multiType = explode('|', $type);
            $multiTypeSafe = array();
            foreach ($multiType as $singleType) {
                if (!in_array($singleType, $ignoreTypes)) {
                    if (isset($replace[$singleType])) {
                        $singleType = $replace[$singleType];
                    }
                    $multiTypeSafe[] = $singleType;
                }
            }
            $filteredType = implode('|', $multiTypeSafe);
        }
        else {
            if (!in_array($type, $ignoreTypes)) {
                $filteredType = $type;
                if (isset($replace[$type])) {
                    $filteredType = $replace[$type];
                }
            }
        }
        if ($filteredType) {
            $filteredType = str_replace('-', ' ', $filteredType);
            $filteredType = trim($filteredType);
            if (strpos($type, ' ')) {
                $filteredType = YdStringHelper::getBetweenString($type, false, ' ');
            }
        }

        return $filteredType;

    }

}

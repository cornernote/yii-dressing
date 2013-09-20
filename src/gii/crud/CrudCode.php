<?php

/**
 * Class CrudCode
 *
 * @property $modelClass
 * @property $controllerClass
 * @property CDbTableSchema $tableSchema
 *
 */
class CrudCode extends CCodeModel
{
    /**
     * @var
     */
    public $model;
    /**
     * @var
     */
    public $controller;
    /**
     * @var string
     */
    public $baseControllerClass = 'WebController';

    /**
     * @var
     */
    private $_modelClass;
    /**
     * @var CDbTableSchema
     */
    private $_table;

    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('model, controller', 'filter', 'filter' => 'trim'),
            array('model, controller, baseControllerClass', 'required'),
            array('model', 'match', 'pattern' => '/^\w+[\w+\\.]*$/', 'message' => '{attribute} should only contain word characters and dots.'),
            array('controller', 'match', 'pattern' => '/^\w+[\w+\\/]*$/', 'message' => '{attribute} should only contain word characters and slashes.'),
            array('baseControllerClass', 'match', 'pattern' => '/^[a-zA-Z_]\w*$/', 'message' => '{attribute} should only contain word characters.'),
            array('baseControllerClass', 'validateReservedWord', 'skipOnError' => true),
            array('model', 'validateModel'),
            array('baseControllerClass', 'sticky'),
        ));
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'model' => 'Model Class',
            'controller' => 'Controller ID',
            'baseControllerClass' => 'Base Controller Class',
        ));
    }

    /**
     * @return array
     */
    public function requiredTemplates()
    {
        return array(
            'controller.php',
        );
    }

    /**
     * @throws CHttpException
     */
    public function init()
    {
        if (Yii::app()->db === null)
            throw new CHttpException(500, 'An active "db" connection is required to run this generator.');
        parent::init();
    }

    /**
     * @return string
     */
    public function successMessage()
    {
        $link = CHtml::link('try it now', Yii::app()->createUrl($this->controller), array('target' => '_blank'));
        return "The controller has been generated successfully. You may $link.";
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateModel($attribute, $params)
    {
        if ($this->hasErrors('model'))
            return;
        $class = @Yii::import($this->model, true);
        if (!is_string($class) || !$this->classExists($class))
            $this->addError('model', "Class '{$this->model}' does not exist or has syntax error.");
        elseif (!is_subclass_of($class, 'CActiveRecord'))
            $this->addError('model', "'{$this->model}' must extend from CActiveRecord.");
        else {
            $table = CActiveRecord::model($class)->tableSchema;
            if ($table->primaryKey === null)
                $this->addError('model', "Table '{$table->name}' does not have a primary key.");
            elseif (is_array($table->primaryKey))
                $this->addError('model', "Table '{$table->name}' has a composite primary key which is not supported by crud generator.");
            else {
                $this->_modelClass = $class;
                $this->_table = $table;
            }
        }
    }

    /**
     *
     */
    public function prepare()
    {
        $this->files = array();
        $templatePath = $this->templatePath;
        $controllerTemplateFile = $templatePath . DIRECTORY_SEPARATOR . 'controller.php';

        $this->files[] = new CCodeFile(
            $this->controllerFile,
            $this->render($controllerTemplateFile)
        );

        $files = scandir($templatePath);
        foreach ($files as $file) {
            if (is_file($templatePath . '/' . $file) && CFileHelper::getExtension($file) === 'php' && $file !== 'controller.php') {
                $this->files[] = new CCodeFile(
                    $this->viewPath . DIRECTORY_SEPARATOR . $file,
                    $this->render($templatePath . '/' . $file)
                );
            }
        }
    }

    /**
     * @return mixed
     */
    public function getModelClass()
    {
        return $this->_modelClass;
    }

    /**
     * @return string
     */
    public function getControllerClass()
    {
        if (($pos = strrpos($this->controller, '/')) !== false)
            return ucfirst(substr($this->controller, $pos + 1)) . 'Controller';
        else
            return ucfirst($this->controller) . 'Controller';
    }

    /**
     * @return mixed|WebApplication
     */
    public function getModule()
    {
        if (($pos = strpos($this->controller, '/')) !== false) {
            $id = substr($this->controller, 0, $pos);
            if (($module = Yii::app()->getModule($id)) !== null)
                return $module;
        }
        return Yii::app();
    }

    /**
     * @return string
     */
    public function getControllerID()
    {
        if ($this->getModule() !== Yii::app())
            $id = substr($this->controller, strpos($this->controller, '/') + 1);
        else
            $id = $this->controller;
        if (($pos = strrpos($id, '/')) !== false)
            $id[$pos + 1] = strtolower($id[$pos + 1]);
        else
            $id[0] = strtolower($id[0]);
        return $id;
    }

    /**
     * @return mixed
     */
    public function getUniqueControllerID()
    {
        $id = $this->controller;
        if (($pos = strrpos($id, '/')) !== false)
            $id[$pos + 1] = strtolower($id[$pos + 1]);
        else
            $id[0] = strtolower($id[0]);
        return $id;
    }

    /**
     * @return string
     */
    public function getControllerFile()
    {
        $module = $this->getModule();
        $id = $this->getControllerID();
        if (($pos = strrpos($id, '/')) !== false)
            $id[$pos + 1] = strtoupper($id[$pos + 1]);
        else
            $id[0] = strtoupper($id[0]);
        return $module->getControllerPath() . '/' . $id . 'Controller.php';
    }

    /**
     * @return string
     */
    public function getViewPath()
    {
        return $this->getModule()->getViewPath() . '/' . $this->getControllerID();
    }

    /**
     * @return mixed
     */
    public function getTableSchema()
    {
        return $this->_table;
    }

    /**
     * @param $modelClass
     * @param $column
     * @return string
     */
    public function generateInputLabel($modelClass, $column)
    {
        return "CHtml::activeLabelEx(\$model,'{$column->name}')";
    }

    /**
     * @param $modelClass
     * @param $column
     * @return string
     */
    public function generateInputField($modelClass, $column)
    {
        if ($column->type === 'boolean')
            return "CHtml::activeCheckBox(\$model,'{$column->name}')";
        elseif (stripos($column->dbType, 'text') !== false)
            return "CHtml::activeTextArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
        else {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name))
                $inputField = 'activePasswordField';
            else
                $inputField = 'activeTextField';

            if ($column->type !== 'string' || $column->size === null)
                return "CHtml::{$inputField}(\$model,'{$column->name}')";
            else {
                if (($size = $maxLength = $column->size) > 60)
                    $size = 60;
                return "CHtml::{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
            }
        }
    }

    /**
     * @param $modelClass
     * @param $column
     * @return string
     */
    public function generateActiveLabel($modelClass, $column)
    {
        return "\$form->labelEx(\$model,'{$column->name}')";
    }

    /**
     * @param $modelClass
     * @param $column
     * @return string
     */
    public function generateActiveField($modelClass, $column)
    {
        if ($column->type === 'boolean')
            return "\$form->checkBox(\$model,'{$column->name}')";
        elseif (stripos($column->dbType, 'text') !== false)
            return "\$form->textArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
        else {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name))
                $inputField = 'passwordField';
            else
                $inputField = 'textField';

            if ($column->type !== 'string' || $column->size === null)
                return "\$form->{$inputField}(\$model,'{$column->name}')";
            else {
                if (($size = $maxLength = $column->size) > 60)
                    $size = 60;
                return "\$form->{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
            }
        }
    }

    /**
     * @param $columns
     * @return string
     */
    public function guessNameColumn($columns)
    {
        foreach ($columns as $column) {
            if (!strcasecmp($column->name, 'name'))
                return $column->name;
        }
        foreach ($columns as $column) {
            if (!strcasecmp($column->name, 'title'))
                return $column->name;
        }
        foreach ($columns as $column) {
            if ($column->isPrimaryKey)
                return $column->name;
        }
        return 'id';
    }
}
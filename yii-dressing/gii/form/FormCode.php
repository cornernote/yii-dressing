<?php

/**
 * Class FormCode
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
class FormCode extends CCodeModel
{
    /**
     * @var
     */
    public $model;
    /**
     * @var string
     */
    public $viewPath = 'application.views';
    /**
     * @var
     */
    public $viewName;
    /**
     * @var
     */
    public $scenario;

    /**
     * @var
     */
    private $_modelClass;

    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('model, viewName, scenario', 'filter', 'filter' => 'trim'),
            array('model, viewName, viewPath', 'required'),
            array('model, viewPath', 'match', 'pattern' => '/^\w+[\.\w+]*$/', 'message' => '{attribute} should only contain word characters and dots.'),
            array('viewName', 'match', 'pattern' => '/^\w+[\\/\w+]*$/', 'message' => '{attribute} should only contain word characters and slashes.'),
            array('model', 'validateModel'),
            array('viewPath', 'validateViewPath'),
            array('scenario', 'match', 'pattern' => '/^\w+$/', 'message' => '{attribute} should only contain word characters.'),
            array('viewPath', 'sticky'),
        ));
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'model' => 'Model Class',
            'viewName' => 'View Name',
            'viewPath' => 'View Path',
            'scenario' => 'Scenario',
        ));
    }

    /**
     * @return array
     */
    public function requiredTemplates()
    {
        return array(
            'form.php',
            'action.php',
        );
    }

    /**
     * @return string
     */
    public function successMessage()
    {
        $output = <<<EOD
<p>The form has been generated successfully.</p>
<p>You may add the following code in an appropriate controller class to invoke the view:</p>
EOD;
        $code = "<?php\n" . $this->render($this->templatePath . '/action.php');
        return $output . highlight_string($code, true);
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
        elseif (!is_subclass_of($class, 'CModel'))
            $this->addError('model', "'{$this->model}' must extend from CModel.");
        else
            $this->_modelClass = $class;
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateViewPath($attribute, $params)
    {
        if ($this->hasErrors('viewPath'))
            return;
        if (Yii::getPathOfAlias($this->viewPath) === false)
            $this->addError('viewPath', 'View Path must be a valid path alias.');
    }

    /**
     *
     */
    public function prepare()
    {
        $templatePath = $this->templatePath;
        $this->files[] = new CCodeFile(
            Yii::getPathOfAlias($this->viewPath) . '/' . $this->viewName . '.php',
            $this->render($templatePath . '/form.php')
        );
    }

    /**
     * @return mixed
     */
    public function getModelClass()
    {
        return $this->_modelClass;
    }

    /**
     * @return mixed
     */
    public function getModelAttributes()
    {
        $model = new $this->_modelClass($this->scenario);
        return $model->getSafeAttributeNames();
    }
}
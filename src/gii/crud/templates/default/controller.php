<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * @var $this CrudCode
 */

echo "<?php\n";
echo "/**\n";
echo " *\n";
echo " */\n";
echo "class " . $this->controllerClass . " extends " . $this->baseControllerClass . "\n";
echo "{\n";
echo "\n";

// access control
echo "    /**\n";
echo "     * Access Control\n";
echo "     * @return array\n";
echo "     */\n";
echo "    public function accessRules()\n";
echo "    {\n";
echo "        return array(\n";
echo "            array('allow',\n";
echo "                'actions' => array('index', 'view', 'log', 'create', 'update', 'delete'),\n";
echo "                'roles' => array('admin'),\n";
echo "                //'users' => array('*','@','?'), // all, user, guest\n";
echo "            ),\n";
echo "            array('deny', 'users' => array('*')),\n";
echo "        );\n";
echo "    }\n";
echo "\n";

// filters
echo "    /**\n";
echo "     * Filters\n";
echo "     */\n";
echo "    //public function filters()\n";
echo "    //{\n";
echo "    //    return array(\n";
echo "    //        'inlineFilterName',\n";
echo "    //        array(\n";
echo "    //            'class'=>'path.to.FilterClass',\n";
echo "    //            'propertyName'=>'propertyValue',\n";
echo "    //        ),\n";
echo "    //    );\n";
echo "    //}\n";
echo "\n";

// actions
echo "    /**\n";
echo "     * Actions\n";
echo "     */\n";
echo "    //public function actions()\n";
echo "    //{\n";
echo "    //    return array(\n";
echo "    //        'action1' => 'path.to.ActionClass',\n";
echo "    //        'action2' => array(\n";
echo "    //            'class' => 'path.to.AnotherActionClass',\n";
echo "    //            'propertyName' => 'propertyValue',\n";
echo "    //        ),\n";
echo "    //    );\n";
echo "    //}\n";
echo "\n";

// index
echo "    /**\n";
echo "     * Index\n";
echo "     */\n";
echo "    public function actionIndex()\n";
echo "    {\n";
echo "        \$" . lcfirst($this->modelClass) . " = new " . $this->modelClass . "('search');\n";
echo "        if (!empty(\$_GET['" . $this->modelClass . "']))\n";
echo "            \$" . lcfirst($this->modelClass) . "->attributes = \$_GET['" . $this->modelClass . "'];\n";
echo "\n";
echo "        \$this->render('index', array(\n";
echo "            '" . lcfirst($this->modelClass) . "' => \$" . lcfirst($this->modelClass) . ",\n";
echo "        ));\n";
echo "    }\n";
echo "\n";

// view
echo "    /**\n";
echo "     * View\n";
echo "     * @param \$id\n";
echo "     */\n";
echo "    public function actionView(\$id)\n";
echo "    {\n";
echo "        /** @var \$" . lcfirst($this->modelClass) . " " . $this->modelClass . " */\n";
echo "        \$" . lcfirst($this->modelClass) . " = \$this->loadModel(\$id);\n";
echo "\n";
if (in_array('deleted', CHtml::listData($this->tableSchema->columns, 'name', 'name'))) {
    echo "        // check for deleted " . $this->modelClass . "\n";
    echo "        if (\$" . lcfirst($this->modelClass) . "->deleted) {\n";
    echo "            user()->addFlash('THIS RECORD IS DELETED', 'warning');\n";
    echo "        }\n";
    echo "\n";
}
echo "        \$this->render('view', array(\n";
echo "            '" . lcfirst($this->modelClass) . "' => \$" . lcfirst($this->modelClass) . ",\n";
echo "        ));\n";
echo "    }\n";
echo "\n";

// log
echo "    /**\n";
echo "     * Log\n";
echo "     * @param \$id\n";
echo "     */\n";
echo "    public function actionLog(\$id)\n";
echo "    {\n";
echo "        /** @var \$" . lcfirst($this->modelClass) . " " . $this->modelClass . " */\n";
echo "        \$" . lcfirst($this->modelClass) . " = \$this->loadModel(\$id);\n";
echo "\n";
echo "        \$this->render('log', array(\n";
echo "            '" . lcfirst($this->modelClass) . "' => \$" . lcfirst($this->modelClass) . ",\n";
echo "        ));\n";
echo "    }\n";
echo "\n";

// create
echo "    /**\n";
echo "     * Create\n";
echo "     */\n";
echo "    public function actionCreate()\n";
echo "    {\n";
echo "        \$" . lcfirst($this->modelClass) . " = new " . $this->modelClass . "('create');\n";
echo "\n";
echo "        \$this->performAjaxValidation(\$" . lcfirst($this->modelClass) . ", '" . lcfirst($this->modelClass) . "-form');\n";
echo "        if (isset(\$_POST['" . $this->modelClass . "'])) {\n";
echo "            \$" . lcfirst($this->modelClass) . "->attributes = \$_POST['" . $this->modelClass . "'];\n";
echo "            if (\$" . lcfirst($this->modelClass) . "->save()) {\n";
echo "                user()->addFlash(strtr('" . $this->modelClass . " :name has been created.', array(':name' => \$" . lcfirst($this->modelClass) . "->getName())), 'success');\n";
echo "                \$this->redirect(ReturnUrl::getUrl(\$" . lcfirst($this->modelClass) . "->getUrl()));\n";
echo "            }\n";
echo "            user()->addFlash(t('" . $this->modelClass . " could not be created.'), 'warning');\n";
echo "        }\n";
echo "        else {\n";
echo "            if (isset(\$_GET['" . $this->modelClass . "'])) {\n";
echo "                \$" . lcfirst($this->modelClass) . "->attributes = \$_GET['" . $this->modelClass . "'];\n";
echo "            }\n";
echo "        }\n";
echo "\n";
echo "        \$this->render('create', array(\n";
echo "            '" . lcfirst($this->modelClass) . "' => \$" . lcfirst($this->modelClass) . ",\n";
echo "        ));\n";
echo "    }\n";
echo "\n";

// update
echo "    /**\n";
echo "     * Update\n";
echo "     * @param \$id\n";
echo "     */\n";
echo "    public function actionUpdate(\$id)\n";
echo "    {\n";
echo "        /** @var \$" . lcfirst($this->modelClass) . " " . $this->modelClass . " */\n";
echo "        \$" . lcfirst($this->modelClass) . " = \$this->loadModel(\$id);\n";
echo "\n";
echo "        \$this->performAjaxValidation(\$" . lcfirst($this->modelClass) . ", '" . lcfirst($this->modelClass) . "-form');\n";
echo "        if (isset(\$_POST['" . $this->modelClass . "'])) {\n";
echo "            \$" . lcfirst($this->modelClass) . "->attributes = \$_POST['" . $this->modelClass . "'];\n";
echo "            if (\$" . lcfirst($this->modelClass) . "->save()) {\n";
echo "                user()->addFlash(strtr('" . $this->modelClass . " :name has been updated.', array(':name' => \$" . lcfirst($this->modelClass) . "->getName())), 'success');\n";
echo "                \$this->redirect(ReturnUrl::getUrl(\$" . lcfirst($this->modelClass) . "->getUrl()));\n";
echo "            }\n";
echo "            user()->addFlash(t('" . $this->modelClass . " could not be updated.'), 'warning');\n";
echo "        }\n";
echo "\n";
echo "        \$this->render('update', array(\n";
echo "            '" . lcfirst($this->modelClass) . "' => \$" . lcfirst($this->modelClass) . ",\n";
echo "        ));\n";
echo "    }\n";
echo "\n";

// delete
echo "    /**\n";
echo "     * Delete and Undelete\n";
echo "     * @param \$id\n";
echo "     */\n";
echo "    public function actionDelete(\$id = null)\n";
echo "    {\n";
echo "        \$task = sf('task', '" . $this->modelClass . "')=='undelete' ? 'undelete' : 'delete';\n";
echo "        if (sf('confirm', '" . $this->modelClass . "')) {\n";
echo "            \$ids = sfGrid(\$id);\n";
echo "            foreach (\$ids as \$id) {\n";
echo "                \$" . lcfirst($this->modelClass) . " = " . $this->modelClass . "::model()->findByPk(\$id);\n";
echo "                if (!\$" . lcfirst($this->modelClass) . ") {\n";
echo "                    continue;\n";
echo "                }\n";
echo "                call_user_func(array(\$" . lcfirst($this->modelClass) . ", \$task));\n";
echo "                user()->addFlash(strtr('" . $this->modelClass . " :name has been :tasked.', array(\n";
echo "                    ':name' => \$" . lcfirst($this->modelClass) . "->getName(),\n";
echo "                    ':tasked' => \$task . 'd',\n";
echo "                )), 'success');\n";
echo "            }\n";
echo "            \$this->redirect(ReturnUrl::getUrl(user()->getState('index." . lcfirst($this->modelClass) . "', array('/" . lcfirst($this->modelClass) . "/index'))));\n";
echo "        }\n";
echo "\n";
echo "        \$this->render('delete', array(\n";
echo "            'id' => \$id,\n";
echo "            'task' => \$task,\n";
echo "        ));\n";
echo "    }\n";
echo "\n";

// end class
echo "}\n";

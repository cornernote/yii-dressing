<?php
/**
 * The following variables are available in this template:
 * @var $this CrudCode
 */

echo "<?php\n";
echo "/**\n";
echo " * @var \$this " . $this->controllerClass . "\n";
echo " * @var \$" . lcfirst($this->modelClass) . " " . $this->modelClass . "\n";
echo " */\n";
echo "\n";
echo "\$this->pageTitle = \$this->pageHeading = \$" . lcfirst($this->modelClass) . "->getName() . ' - ' . \$this->getName() . ' ' . Yii::t('app', 'Update');\n";
echo "\n";
echo "\$this->breadcrumbs[\$this->getName() . ' ' . Yii::t('app', 'List')] = Yii::app()->user->getState('index." . lcfirst($this->modelClass) . "', array('/" . lcfirst($this->modelClass) . "/index'));\n";
echo "\$this->breadcrumbs[\$" . lcfirst($this->modelClass) . "->getName()] = \$" . lcfirst($this->modelClass) . "->getUrl();\n";
echo "\$this->breadcrumbs[] = Yii::t('app', 'Update');\n";
echo "\n";
echo "\$this->renderPartial('_menu', array(\n";
echo "    '" . lcfirst($this->modelClass) . "' => \$" . lcfirst($this->modelClass) . ",\n";
echo "));\n";
echo "\$this->renderPartial('_form', array(\n";
echo "    '" . lcfirst($this->modelClass) . "' => \$" . lcfirst($this->modelClass) . ",\n";
echo "));\n";

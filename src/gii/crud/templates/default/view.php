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
echo "\$this->pageTitle = \$this->pageHeading = \$" . lcfirst($this->modelClass) . "->getName() . ' - ' . \$this->getName() . ' ' . t('View');\n";
echo "\n";
echo "\$this->breadcrumbs = array();\n";
echo "\$this->breadcrumbs[\$this->getName() . ' ' . t('List')] = user()->getState('index." . lcfirst($this->modelClass) . "', array('/" . lcfirst($this->modelClass) . "/index'));\n";
echo "\$this->breadcrumbs[] = \$" . lcfirst($this->modelClass) . "->getName();\n";
echo "\n";
echo "\$this->renderPartial('_menu', array(\n";
echo "    '" . lcfirst($this->modelClass) . "' => \$" . lcfirst($this->modelClass) . ",\n";
echo "));\n";
echo "\n";
echo "\$attributes = array();\n";
foreach ($this->tableSchema->columns as $column) {
    echo "\$attributes[] = array(\n";
    echo "    'name' => '" . $column->name . "',\n";
    echo ");\n";
}
echo "\n";
echo "\$this->widget('widgets.DetailView', array(\n";
echo "    'data' => \$" . lcfirst($this->modelClass) . ",\n";
echo "    'attributes' => \$attributes,\n";
echo "));\n";
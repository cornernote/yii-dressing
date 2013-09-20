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
echo "\$columns = array();\n";
$count = 0;
foreach ($this->tableSchema->columns as $column) {
    if (++$count == 7)
        echo "\t\t/*\n";
    echo "\$columns[] = array(\n";
    echo "    'name' => '" . $column->name . "',\n";
    if ($column->autoIncrement) {
        echo "    'class' => 'widgets.TbDropdownColumn',\n";
    }
    echo ");\n";
}
if ($count >= 7)
    echo "\t\t*/\n";
echo "\n";
echo "// multi actions\n";
echo "\$multiActions = array();\n";
echo "\$multiActions[] = array(\n";
echo "    'name' => t('Delete'),\n";
echo "    'url' => url('/" . lcfirst($this->modelClass) . "/delete'),\n";
echo ");\n";
echo "\n";
echo "// grid\n";
echo "\$this->widget('widgets.GridView', array(\n";
echo "    'id' => '" . lcfirst($this->modelClass) . "-grid',\n";
echo "    'dataProvider' => \$" . lcfirst($this->modelClass) . "->search(),\n";
echo "    'filter' => \$" . lcfirst($this->modelClass) . ",\n";
echo "    'columns' => \$columns,\n";
echo "    'multiActions' => \$multiActions,\n";
echo "));\n";

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
echo "// list\n";
echo "\$this->widget('widgets.ListView', array(\n";
echo "    'id' => '" . lcfirst($this->modelClass) . "-list',\n";
echo "    'dataProvider' => \$" . lcfirst($this->modelClass) . "->search(),\n";
echo "    'itemView' => '_list_view',\n";
echo "));\n";

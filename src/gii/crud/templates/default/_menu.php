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
echo "// index\n";
echo "if (\$this->action->id == 'index') {\n";
echo "    \$this->menu = Menu::getItemsFromMenu('Main');\n";
echo "    return; // no more links\n";
echo "}\n";
echo "\n";
echo "// create\n";
echo "if (\$" . lcfirst($this->modelClass) . "->isNewRecord) {\n";
echo "    \$this->menu[] = array(\n";
echo "        'label' => t('Create'),\n";
echo "        'url' => array('/" . lcfirst($this->modelClass) . "/create'),\n";
echo "    );\n";
echo "    return; // no more links\n";
echo "}\n";
echo "\n";
echo "// view\n";
echo "\$this->menu[] = array(\n";
echo "    'label' => t('View'),\n";
echo "    'url' => \$" . lcfirst($this->modelClass) . "->getUrl(),\n";
echo ");\n";
echo "\n";
echo "// others\n";
echo "foreach (\$" . lcfirst($this->modelClass) . "->getDropdownLinkItems(true) as \$linkItem) {\n";
echo "    \$this->menu[] = \$linkItem;\n";
echo "}\n";
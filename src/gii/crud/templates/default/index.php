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
echo "user()->setState('index." . lcfirst($this->modelClass) . "', ru());\n";
echo "\$this->pageTitle = \$this->pageHeading = \$this->getName() . ' ' . t('List');\n";
echo "\$this->breadcrumbs = array(\$this->getName() . ' ' . t('List'));\n";
echo "\n";
echo "\$this->menu = Menu::getItemsFromMenu('Main');\n";
echo "\n";
echo "echo '<div class=\"spacer\">';\n";
echo "\$this->widget('bootstrap.widgets.TbButton', array(\n";
echo "    'label' => t('Create') . ' ' . \$this->getName(),\n";
echo "    'url' => array('/" . lcfirst($this->modelClass) . "/create'),\n";
echo "    'type' => 'primary',\n";
echo "    'htmlOptions' => array('data-toggle' => 'modal-remote'),\n";
echo "));\n";
echo "echo ' ';\n";
echo "\$this->widget('bootstrap.widgets.TbButton', array(\n";
echo "    'label' => t('Search'),\n";
echo "    'htmlOptions' => array('class' => 'search-button'),\n";
echo "    'toggle' => true,\n";
echo "));\n";
echo "if (user()->getState('index." . lcfirst($this->modelClass) . "') != url('/" . lcfirst($this->modelClass) . "/index')) {\n";
echo "    echo ' ';\n";
echo "    \$this->widget('bootstrap.widgets.TbButton', array(\n";
echo "        'label' => t('Reset Filters'),\n";
echo "        'url' => array('/" . lcfirst($this->modelClass) . "/index'),\n";
echo "    ));\n";
echo "}\n";
echo "echo '</div>';\n";
echo "\n";
echo "// search\n";
echo "\$this->renderPartial('/" . lcfirst($this->modelClass) . "/_search', array(\n";
echo "    '" . lcfirst($this->modelClass) . "' => \$" . lcfirst($this->modelClass) . ",\n";
echo "));\n";
echo "\n";
echo "// grid\n";
echo "\$this->renderPartial('/" . lcfirst($this->modelClass) . "/_grid', array(\n";
echo "    '" . lcfirst($this->modelClass) . "' => \$" . lcfirst($this->modelClass) . ",\n";
echo "));\n";

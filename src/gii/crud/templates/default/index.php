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
echo "Yii::app()->user->setState('index." . lcfirst($this->modelClass) . "', Yii::app()->request->requestUri);\n";
echo "\$this->pageTitle = \$this->pageHeading = \$this->getName() . ' ' . Yii::t('app', 'List');\n";
echo "\$this->breadcrumbs[] = \$this->getName() . ' ' . Yii::t('app', 'List');\n";
echo "\n";
echo "\$this->menu = YdMenu::getItemsFromMenu('Main');\n";
echo "\n";
echo "echo '<div class=\"spacer\">';\n";
echo "\$this->widget('bootstrap.widgets.TbButton', array(\n";
echo "    'label' => Yii::t('app', 'Create') . ' ' . \$this->getName(),\n";
echo "    'url' => array('/" . lcfirst($this->modelClass) . "/create'),\n";
echo "    'type' => 'primary',\n";
echo "    'htmlOptions' => array('data-toggle' => 'modal-remote'),\n";
echo "));\n";
echo "echo ' ';\n";
echo "\$this->widget('bootstrap.widgets.TbButton', array(\n";
echo "    'label' => Yii::t('app', 'Search'),\n";
echo "    'htmlOptions' => array('class' => '" . lcfirst($this->modelClass) . "-grid-search'),\n";
echo "    'toggle' => true,\n";
echo "));\n";
echo "if (Yii::app()->user->getState('index." . lcfirst($this->modelClass) . "') != Yii::app()->createUrl('/" . lcfirst($this->modelClass) . "/index')) {\n";
echo "    echo ' ';\n";
echo "    \$this->widget('bootstrap.widgets.TbButton', array(\n";
echo "        'label' => Yii::t('app', 'Reset Filters'),\n";
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

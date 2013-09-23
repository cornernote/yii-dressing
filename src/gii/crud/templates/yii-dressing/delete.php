<?php
/**
 * The following variables are available in this template:
 * @var $this CrudCode
 */

echo "<?php\n";
echo "/**\n";
echo " * @var \$this " . $this->controllerClass . "\n";
echo " * @var \$id int\n";
echo " * @var \$task string\n";
echo " */\n";
echo "\n";
echo "\$this->pageTitle = \$this->pageHeading = \$this->getName() . ' ' . Yii::t('app', ucfirst(\$task));\n";
echo "\n";
echo "\$this->breadcrumbs[\$this->getName() . ' ' . Yii::t('app', 'List')] = Yii::app()->user->getState('index." . lcfirst($this->modelClass) . "', array('/" . lcfirst($this->modelClass) . "/index'));\n";
echo "\$this->breadcrumbs[] = Yii::t('app', ucfirst(\$task));\n";
echo "\n";
echo "\$" . lcfirst($this->modelClass) . " = \$id ? " . $this->modelClass . "::model()->findByPk(\$id) : new " . $this->modelClass . "('search');\n";
echo "/** @var YdActiveForm \$form */\n";
echo "\$form = \$this->beginWidget('dressing.widgets.YdActiveForm', array(\n";
echo "    'id' => '" . lcfirst($this->modelClass) . "-' . \$task . '-form',\n";
echo "    'type' => 'horizontal',\n";
echo "    'action' => array('/" . lcfirst($this->modelClass) . "/delete', 'id' => \$id, 'task' => \$task, 'confirm' => 1),\n";
echo "));\n";
echo "echo \$this->getGridIdHiddenFields(\$id);\n";
echo "echo \$form->beginModalWrap();\n";
echo "echo \$form->errorSummary(\$" . lcfirst($this->modelClass) . ");\n";
echo "\n";
echo "echo '<fieldset>';\n";
echo "echo '<legend>' . Yii::t('app', 'Selected Records') . '</legend>';\n";
echo "\$" . lcfirst($this->modelClass) . "s = " . $this->modelClass . "::model()->findAll('t.id IN (' . implode(',', \$this->getGridIds(\$id)) . ')');\n";
echo "if (\$" . lcfirst($this->modelClass) . "s) {\n";
echo "	echo '<ul>';\n";
echo "	foreach (\$" . lcfirst($this->modelClass) . "s as \$" . lcfirst($this->modelClass) . ") {\n";
echo "		echo '<li>';\n";
echo "		echo \$" . lcfirst($this->modelClass) . "->getName();\n";
echo "		echo '</li>';\n";
echo "	}\n";
echo "	echo '</ul>';\n";
echo "}\n";
echo "echo '</fieldset>';\n";
echo "\n";
echo "echo \$form->endModalWrap();\n";
echo "echo '<div class=\"' . \$form->getSubmitRowClass() . '\">';\n";
echo "\$this->widget('bootstrap.widgets.TbButton', array(\n";
echo "    'buttonType' => 'submit',\n";
echo "    'type' => 'primary',\n";
echo "    'label' => Yii::t('app', 'Confirm ' . ucfirst(\$task)),\n";
echo "    'htmlOptions' => array('class' => 'pull-right'),\n";
echo "));\n";
echo "echo '</div>';\n";
echo "\$this->endWidget();\n";
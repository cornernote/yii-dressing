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
echo "Helper::searchToggle('" . lcfirst($this->modelClass) . "-grid');\n";
echo "echo '<div class=\"search-form hide\">';\n";
echo "\n";
echo "/** @var ActiveForm \$form */\n";
echo "\$form = \$this->beginWidget('widgets.ActiveForm', array(\n";
echo "	'action' => url(\$this->route),\n";
echo "	'type' => 'horizontal',\n";
echo "	'method' => 'get',\n";
echo "));\n";
echo "\n";
echo "echo '<fieldset>';\n";
echo "echo '<legend>' . \$this->getName() . ' ' .t('Search') . '</legend>';\n";
foreach ($this->tableSchema->columns as $column) {
    echo "echo \$form->textFieldRow(\$" . lcfirst($this->modelClass) . ", '" . $column->name . "');\n";
}
echo "echo '</fieldset>';\n";
echo "\n";
echo "echo '<div class=\"form-actions\">';\n";
echo "\$this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'icon' => 'search white', 'label' => t('Search')));\n";
echo "echo '</div>';\n";
echo "\n";
echo "\$this->endWidget();\n";
echo "echo '</div>';\n";

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
echo "/** @var ActiveForm \$form */\n";
echo "\$form = \$this->beginWidget('widgets.ActiveForm', array(\n";
echo "    'id' => '" . lcfirst($this->modelClass) . "-form',\n";
echo "    'type' => 'horizontal',\n";
echo "    //'enableAjaxValidation' => true,\n";
echo "));\n";
echo "echo \$form->beginModalWrap();\n";
echo "echo \$form->errorSummary(\$" . lcfirst($this->modelClass) . ");\n";
echo "\n";
foreach ($this->tableSchema->columns as $column) {
    if ($column->autoIncrement)
        continue;
    echo "echo \$form->textFieldRow(\$" . lcfirst($this->modelClass) . ", '" . $column->name . "');\n";
}
echo "\n";
echo "echo \$form->endModalWrap();\n";
echo "echo '<div class=\"' . \$form->getSubmitRowClass() . '\">';\n";
echo "\$this->widget('bootstrap.widgets.TbButton', array(\n";
echo "    'buttonType' => 'submit',\n";
echo "    'type' => 'primary',\n";
echo "    'icon' => 'ok white',\n";
echo "    'label' => \$" . lcfirst($this->modelClass) . "->isNewRecord ? t('Create') : t('Save'),\n";
echo "    'htmlOptions' => array('class' => 'pull-right'),\n";
echo "));\n";
echo "echo '</div>';\n";
echo "\$this->endWidget();\n";
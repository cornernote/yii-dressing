<?php
/**
 * The following variables are available in this template:
 * @var $this CrudCode
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

echo "<?php\n";
echo "/**\n";
echo " * @var \$this " . $this->controllerClass . "\n";
echo " * @var \$" . lcfirst($this->modelClass) . " " . $this->modelClass . "\n";
echo " */\n";
echo "\n";
echo "/** @var YdActiveForm \$form */\n";
echo "\$form = \$this->beginWidget('dressing.widgets.YdActiveForm', array(\n";
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
echo "echo \$form->getSaveButton(\$" . lcfirst($this->modelClass) . ");\n";
echo "echo '</div>';\n";
echo "\$this->endWidget();\n";
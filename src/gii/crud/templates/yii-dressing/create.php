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
echo "\$this->pageTitle = \$this->pageHeading = \$this->getName() . ' ' . Yii::t('app', 'Create');\n";
echo "\n";
echo "\$this->breadcrumbs[\$this->getName() . ' ' . Yii::t('app', 'List')] = Yii::app()->user->getState('index." . lcfirst($this->modelClass) . "', array('/" . lcfirst($this->modelClass) . "/index'));\n";
echo "\$this->breadcrumbs[] = Yii::t('app', 'Create');\n";
echo "\n";
echo "\$this->renderPartial('_menu', array(\n";
echo "    '" . lcfirst($this->modelClass) . "' => \$" . lcfirst($this->modelClass) . ",\n";
echo "));\n";
echo "\$this->renderPartial('_form', array(\n";
echo "    '" . lcfirst($this->modelClass) . "' => \$" . lcfirst($this->modelClass) . ",\n";
echo "));\n";
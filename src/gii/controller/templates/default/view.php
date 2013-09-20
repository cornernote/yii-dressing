<?php
/**
 * This is the template for generating an action view file.
 * The following variables are available in this template:
 * @var $this ControllerCode
 * @var $action string
 */
echo "<?php\n";
echo "/**\n";
echo " * @var \$this " . $this->getControllerClass() . "\n";
echo " * @var \$" . $this->getUniqueControllerID() . " " . $this->controller . "\n";
echo " */\n";
echo "\n";

if ($action === 'index') {
    echo "user()->setState('index." . $this->getUniqueControllerID() . "', ru());\n";
    echo "\n";
    echo "\$this->pageTitle = \$this->pageHeading = \$this->getName() . ' ' . t('List');\n";
    echo "\n";
    echo "\$this->breadcrumbs = array(\$this->getName() . ' ' . t('List'));\n";
}
else {
    $action = ucfirst($action);
    echo "\$this->pageTitle = \$this->pageHeading = \$" . $this->getUniqueControllerID() . "->getName() . ' - ' . \$this->getName() . ' ' . t('" . $action . "');\n";
    echo "\n";
    echo "\$this->breadcrumbs = array();\n";
    echo "\$this->breadcrumbs[\$this->getName() . ' ' . t('List')] = user()->getState('index." . $this->getUniqueControllerID() . "', array('/" . $this->getUniqueControllerID() . "/index'));\n";
    echo "\$this->breadcrumbs[] = \$" . $this->getUniqueControllerID() . "->getName();\n";
}
echo "\n";

echo "echo '<p>You may change the content of this page by modifying the file <code>' . __FILE__ . '</code>.</p>';";

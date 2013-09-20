<?php
/**
 * This is the template for generating the model class of a specified table.
 * @var $this ModelCode
 * @var $tableName
 * @var $modelClass
 * @var $columns
 * @var $labels
 * @var $rules
 * @var $relations
 * @var $connectionId
 */

echo "<?php\n";
echo "/**\n";
echo " * --- BEGIN GenerateProperties ---\n";
echo " *\n";
echo " * you need to goto the following page in a browser:\n";
echo " * /tool/generateProperties/modelName/" . $modelClass . "\n";
echo " *\n";
echo " * --- END GenerateProperties ---\n";
echo " */\n";
echo "\n";
echo "class " . $modelClass . " extends " . $this->baseClass . "\n";
echo "{\n";
echo "\n";
echo "    /**\n";
echo "     * Returns the static model of the specified AR class.\n";
echo "     * @param string \$className active record class name.\n";
echo "     * @return " . $modelClass . " the static model class\n";
echo "     */\n";
echo "    public static function model(\$className=__CLASS__)\n";
echo "    {\n";
echo "        return parent::model(\$className);\n";
echo "    }\n";
echo "\n";
if ($connectionId != 'db') {
    echo "    /**\n";
    echo "     * @return CDbConnection database connection\n";
    echo "     */\n";
    echo "    public function getDbConnection()\n";
    echo "    {\n";
    echo "        return Yii::app()->" . $connectionId . ";\n";
    echo "    }\n";
    echo "\n";
}
echo "    /**\n";
echo "     * @return string the associated database table name\n";
echo "     */\n";
echo "    public function tableName()\n";
echo "    {\n";
echo "        return '" . $tableName . "';\n";
echo "    }\n";
echo "\n";
echo "    /**\n";
echo "     * @return array validation rules for model attributes.\n";
echo "     */\n";
echo "    public function rules()\n";
echo "    {\n";
echo "        \$rules = array();\n";
foreach ($rules as $rule) {
    echo "        \$rules[] = " . $rule . ";\n";
}
echo "        return \$rules;\n";
echo "    }\n";
echo "\n";
echo "    /**\n";
echo "     * @return array containing model behaviors\n";
echo "     */\n";
echo "    public function behaviors()\n";
echo "    {\n";
echo "        return array(\n";
echo "            'AuditBehavior' => 'behaviors.AuditBehavior',\n";
if (in_array('created', CHtml::listData($columns, 'name', 'name')) || in_array('updated', CHtml::listData($columns, 'name', 'name'))) {
    echo "            'TimestampBehavior' => 'behaviors.TimestampBehavior',\n";
}
if (in_array('deleted', CHtml::listData($columns, 'name', 'name'))) {
    echo "            'SoftDeleteBehavior' => 'behaviors.SoftDeleteBehavior',\n";
}
echo "        );\n";
echo "    }\n";
echo "\n";
echo "    /**\n";
echo "     * @return array relational rules.\n";
echo "     */\n";
echo "    public function relations()\n";
echo "    {\n";
echo "        return array(\n";
foreach ($relations as $name => $relation) {
    echo "            '$name' => $relation,\n";
}
echo "        );\n";
echo "    }\n";
echo "\n";
echo "    /**\n";
echo "     * @return array customized attribute labels (name=>label)\n";
echo "     */\n";
echo "    public function attributeLabels()\n";
echo "    {\n";
echo "        return array(\n";
foreach ($labels as $name => $label) {
    echo "            '$name' => t('$label'),\n";
}
echo "        );\n";
echo "    }\n";
echo "\n";
echo "    /**\n";
echo "     * Retrieves a list of models based on the current search/filter conditions.\n";
echo "     * @param array \$options\n";
echo "     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.\n";
echo "     */\n";
echo "    public function search(\$options = array())\n";
echo "    {\n";
echo "        // Warning: Please modify the following code to remove attributes that\n";
echo "        // should not be searched.\n";
echo "\n";
echo "        \$criteria=new CDbCriteria;\n";
echo "\n";
foreach ($columns as $name => $column) {
    if ($column->type === 'string') {
        echo "        \$criteria->compare('$name',\$this->$name,true);\n";
    }
    else {
        echo "        \$criteria->compare('$name',\$this->$name);\n";
    }
}
echo "\n";
echo "        return new ActiveDataProvider(\$this, CMap::mergeArray(array(\n";
echo "            'criteria' => \$criteria,\n";
echo "        ), \$options));\n";
echo "    }\n";
echo "\n";
echo "    /**\n";
echo "     * Retrieves a list of links to be used in menus.\n";
echo "     * @param bool \$extra\n";
echo "     * @return array\n";
echo "     */\n";
echo "    public function getDropdownLinkItems(\$extra = false)\n";
echo "    {\n";
echo "        \$links = array();\n";
echo "        \$links[] = array('label' => t('Update'), 'url' => \$this->getUrl('update'));\n";
echo "        if (\$extra) {\n";
echo "            \$more = array();\n";
echo "            \$more[] = array('label' => t('Clear Cache'), 'url' => array('/tool/clearCacheModel', 'model' => get_class(\$this), 'id' => \$this->getPrimaryKeyString()));\n";
echo "            \$more[] = array('label' => t('View Log'), 'url' => \$this->getUrl('log'));\n";
if (in_array('deleted', CHtml::listData($columns, 'name', 'name')))
    echo "            if (!\$this->deleted)\n    ";
echo "            \$more[] = array('label' => t('Delete'), 'url' => \$this->getUrl('delete', array('returnUrl' => ReturnUrl::getLinkValue(true))), 'linkOptions' => array('data-toggle' => 'modal-remote'));\n";
if (in_array('deleted', CHtml::listData($columns, 'name', 'name'))) {
    echo "            else\n";
    echo "                \$more[] = array('label' => t('Undelete'), 'url' => \$this->getUrl('delete', array('task' => 'undelete', 'returnUrl' => ReturnUrl::getLinkValue(true))), 'linkOptions' => array('data-toggle' => 'modal-remote'));\n";
}
echo "            \$links[] = array(\n";
echo "                'label' => t('More'),\n";
echo "                'items' => \$more,\n";
echo "            );\n";
echo "        }\n";
echo "        return \$links;\n";
echo "    }\n";
echo "\n";
echo "}\n";
echo "\n";

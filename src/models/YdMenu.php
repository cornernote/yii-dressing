<?php
/**
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'menu'
 *
 * @method YdMenu with() with()
 * @method YdMenu find() find($condition, array $params = array())
 * @method YdMenu[] findAll() findAll($condition = '', array $params = array())
 * @method YdMenu findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method YdMenu[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method YdMenu findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdMenu[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method YdMenu findBySql() findBySql($sql, array $params = array())
 * @method YdMenu[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Methods from behavior SoftDeleteBehavior
 * @method undelete() undelete()
 * @method deleteds() deleteds()
 * @method notdeleteds() notdeleteds()
 *
 * Properties from relation
 * @property YdMenu[] $child
 * @property YdMenu $parent
 *
 * Properties from table fields
 * @property integer $id
 * @property integer $parent_id
 * @property string $label
 * @property string $icon
 * @property string $url
 * @property string $url_params
 * @property string $target
 * @property string $access_role
 * @property integer $sort_order
 * @property integer $enabled
 * @property datetime $created
 * @property datetime $deleted
 *
 * --- END GenerateProperties ---
 */

class YdMenu extends YdActiveRecord
{

    /**
     *
     */
    const MENU_MAIN = 1;
    /**
     *
     */
    const MENU_USER = 2;
    /**
     *
     */
    const MENU_ADMIN = 3;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return YdMenu the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        $rules = array();
        if ($this->scenario == 'search') {
            $rules[] = array('parent_id, label, icon, url, url_params, target, created, modified, deleted, sort_order, enabled, access_role', 'safe');
        }
        if (in_array($this->scenario, array('create', 'update'))) {
            $rules[] = array('label', 'required');
            $rules[] = array('access_role', 'safe');
            $rules[] = array('parent_id, enabled', 'numerical', 'integerOnly' => true);
            $rules[] = array('label, icon, url, url_params, target', 'length', 'max' => 255);
        }
        return $rules;
    }

    /**
     * @return array containing model behaviors
     */
    public function behaviors()
    {
        return array(
            'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
            'SoftDeleteBehavior' => 'dressing.behaviors.YdSoftDeleteBehavior',
            'TimestampBehavior' => 'dressing.behaviors.YdTimestampBehavior',
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'child' => array(
                self::HAS_MANY,
                'YdMenu',
                'parent_id',
                'condition' => 'child.enabled=1 AND child.deleted IS NULL',
                'order' => 'sort_order ASC, label ASC',
            ),
            'parent' => array(
                self::BELONGS_TO,
                'YdMenu',
                'parent_id',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('dressing', 'ID'),
            'parent_id' => Yii::t('dressing', 'Parent'),
            'label' => Yii::t('dressing', 'Label'),
            'icon' => Yii::t('dressing', 'Icon'),
            'url' => Yii::t('dressing', 'Url'),
            'url_params' => Yii::t('dressing', 'Url Params'),
            'target' => Yii::t('dressing', 'Target'),
            'access_role' => Yii::t('dressing', 'Access Role'),
            'created' => Yii::t('dressing', 'Created'),
            'deleted' => Yii::t('dressing', 'Deleted'),
            'sort_order' => Yii::t('dressing', 'Sort Order'),
            'enabled' => Yii::t('dressing', 'Enabled'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param array $options
     * @return YdActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($options = array())
    {
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.label', $this->label, true);
        if ($this->parent_id === 0) {
            $criteria->addCondition('t.parent_id IS NULL');
        }
        elseif ($this->parent_id) {
            $criteria->compare('t.parent_id', $this->parent_id);
        }

        if ($this->deleted == 'deleted') {
            $criteria->addCondition('t.deleted IS NOT NULL');
        }
        else {
            $criteria->addCondition('t.deleted IS NULL');
        }

        // allow $options to change the defaultOrder
        $options = CMap::mergeArray(array(
            'defaultOrder' => 'sort_order ASC, label ASC, t.id DESC',
        ), $options);
        $defaultOrder = $options['defaultOrder'];
        unset($options['defaultOrder']);

        // return the DataProvider
        return new YdActiveDataProvider($this, CMap::mergeArray(array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => $defaultOrder,
            ),
        ), $options));
    }

    /**
     * Retrieves a list of links to be used in grid and menus.
     * @param bool $extra
     * @return array
     */
    public function getMenuLinks($extra = false)
    {
        $links = array();
        $links[] = array('label' => Yii::t('dressing', 'Update'), 'url' => $this->getUrl('update'));
        if ($extra) {
            $more = array();
            $more[] = array('label' => Yii::t('dressing', 'Log'), 'url' => $this->getUrl('log'));
            if (!$this->deleted)
                $more[] = array('label' => Yii::t('dressing', 'Delete'), 'url' => $this->getUrl('delete', array('returnUrl' => Yii::app()->returnUrl->getLinkValue(true))), 'linkOptions' => array('data-toggle' => 'modal-remote'));
            else
                $more[] = array('label' => Yii::t('dressing', 'Undelete'), 'url' => $this->getUrl('delete', array('task' => 'undelete', 'returnUrl' => Yii::app()->returnUrl->getLinkValue(true))), 'linkOptions' => array('data-toggle' => 'modal-remote'));
            $links[] = array(
                'label' => Yii::t('dressing', 'More'),
                'items' => $more,
            );
        }
        return $links;
    }

    /**
     * @return array|string
     */
    public function getMenuUrl()
    {
        if (strpos($this->url, 'http://') === 0) {
            return $this->url;
        }
        if (strpos($this->url, 'https://') === 0) {
            return $this->url;
        }
        if (strpos($this->url, 'javascript:') === 0) {
            return $this->url;
        }
        $urlParams = array($this->url);
        $params = explode('&', $this->url_params);
        foreach ($params as $param) {
            $param = explode('=', $param);
            if (isset($param[1])) {
                if ($param[1] == '{returnUrl}') {
                    $param[1] = Yii::app()->returnUrl->getLinkValue(true);
                }
                $urlParams[$param[0]] = $param[1];
            }
        }
        return $urlParams;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        foreach ($this->child as $child) {
            if ($child->isActive()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $label
     * @param array $options
     * @return array
     */
    static public function getItemsFromMenu($label, $parent_id = 0, $options = array())
    {
        if (!YdHelper::tableExists(Yii::app()->dressing->tableMap['YdMenu']))
            return array();
        $menu = self::model()->findByAttributes(array('label' => $label, 'parent_id' => $parent_id));
        if ($menu) {
            return $menu->getItems($options);
        }
        return array();
    }

    /**
     * @param array $options
     * @return array
     */
    public function getItems($options = array())
    {
        $items = array();
        foreach ($this->child as $menu) {
            if (!$menu->checkAccess())
                continue;
            $items[] = $menu->getItem($options);
        }
        return $items;
    }

    /**
     * @return bool
     */
    public function checkAccess()
    {
        if (!$this->access_role) {
            return true;
        }
        if ($this->access_role == '?') {
            return Yii::app()->user->isGuest;
        }
        if ($this->access_role == '@') {
            return !Yii::app()->user->isGuest;
        }
        if (Yii::app()->user->checkAccess($this->access_role)) {
            return true;
        }
        return false;
    }

    /**
     * @param array $options
     * @return array|string
     */
    public function getItem($options = array())
    {
        $itemOptions = isset($options['itemOptions']) ? $options['itemOptions'] : array();
        $linkOptions = isset($options['linkOptions']) ? $options['linkOptions'] : array();
        if ($this->target) {
            $linkOptions['target'] = $this->target;
        }
        $submenuOptions = isset($options['submenuOptions']) ? $options['submenuOptions'] : array();
        if (isset($options['submenuOptions'])) {
            unset($options['submenuOptions']);
        }

        $childItems = $this->getItems($options);
        if ($this->label == '---') {
            $item = '---';
        }
        else {
            $item = array();
            $item['label'] = $this->label;
            if ($this->url) {
                $item['url'] = $this->getMenuUrl();
            }
            if ($this->icon) {
                $item['icon'] = $this->icon;
            }
            if ($this->isActive()) {
                $item['active'] = true;
            }
            if ($itemOptions) {
                $item['itemOptions'] = $itemOptions;
            }
            if ($linkOptions) {
                $item['linkOptions'] = $linkOptions;
            }
            if ($submenuOptions) {
                $item['submenuOptions'] = $submenuOptions;
            }
            if ($childItems) {
                $item['items'] = $childItems;
            }
        }
        return $item;
    }

    /**
     * Get DropDown data, eg
     * echo $form->dropDownListRow($menu, 'parent_id', YdMenu::model()->getDropDown())
     *
     * @param int $parent_id
     * @param null $condition
     * @return YdMenu[]
     */
    public function getDropDown($parent_id = 0, $condition = null)
    {
        static $dropdown = array();
        if (isset($dropdown[$parent_id]) && $dropdown[$parent_id]) {
            return $dropdown[$parent_id];
        }
        $menus = array();
        $criteria = new CDbCriteria(array(
            'condition' => 'parent_id=:parent_id' . ($condition ? ' AND (' . $condition . ')' : ''),
            'params' => array('parent_id' => $parent_id),
            'order' => 'sort_order, label',
        ));
        $_menus = $this->findAll($criteria);
        foreach ($_menus as $menu) {
            $menus[] = $menu;
            foreach ($menu->child as $child) {
                $child->label = $menu->label . ' > ' . $child->label;
            }
            $menus = array_merge($menus, $menu->child);
        }
        $dropdown[$parent_id] = CHtml::listData($menus, 'id', 'label');
        return $dropdown[$parent_id];
    }

    /**
     * @param YdMenu[] $menus
     * @return YdMenu[]
     */
    public function breadcrumb($menus = array())
    {
        if ($this->parent && $this->parent_id != $this->id && !in_array($this->parent_id, array_keys($menus))) {
            $menus = $this->parent->breadcrumb($menus);
        }
        $menus[$this->id] = $this;
        return $menus;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->label;
    }

    /**
     * @static
     * @return array
     */
    static public function topMenu()
    {
        $menu = array();

        // main
        $menu[] = array(
            'class' => 'bootstrap.widgets.TbMenu',
            'items' => self::getItemsFromMenu('Main'),
        );

        // search
        $menu[] = '<form id="navmenu-header-search" class="navbar-search pull-right" action="' . Yii::app()->createUrl('/site/search') . '"><input type="text" name="term" class="search-query span1" id = "jump-search-box" placeholder="' . Yii::t('dressing', 'Search') . '"><input type="hidden" name="r" value="site/jump"></form>';

        // system
        if (Yii::app()->user->checkAccess('admin')) {
            $menu[] = array(
                'class' => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => array(
                    'class' => 'pull-right',
                ),
                'items' => array(
                    array(
                        'label' => Yii::t('dressing', 'System'),
                        'icon' => 'icon-gears',
                        'items' => self::getItemsFromMenu('System'),
                    ),
                ),
            );
        }

        // help
        $menu[] = array(
            'class' => 'bootstrap.widgets.TbMenu',
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
            'items' => array(
                array(
                    'label' => Yii::t('dressing', 'Help'),
                    'icon' => 'icon-question-sign',
                    'items' => self::getItemsFromMenu('Help'),
                ),
            ),
        );

        return $menu;
    }

    /**
     * @static
     * @return array
     */
    static public function userMenu()
    {
        if (!YdHelper::tableExists(Yii::app()->dressing->tableMap['YdUser']))
            return '';

        ob_start();
        app()->controller->widget('bootstrap.widgets.TbButtonGroup', array(
            'type' => '', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'htmlOptions' => array(
                'id' => 'navmenu-header-account',
                'class' => 'pull-right navbutton',
            ),
            'buttons' => array(
                array(
                    'label' => Yii::app()->user->isGuest ? Yii::t('dressing', 'Login or Signup') : Yii::app()->user->name,
                    'icon' => 'icon-user',
                    'items' => self::getItemsFromMenu('User'),
                ),
            ),
        ));
        return ob_get_clean();
    }

    /**
     * The name of this model to be used in links
     *
     * @return string
     */
    public function getControllerName()
    {
        return 'menu';
    }

}
<?php

/**
 * Class YdSimpleTreeWidget
 */
class YdSimpleTreeWidget extends CInputWidget
{
    /**
     * @var
     */
    private $baseUrl;

    /**
     * @var
     */
    public $ajaxUrl;
    /**
     * @var string
     */
    public $id = 'simpletree_widget';
    /**
     * @var
     */
    public $model;
    /**
     * @var string
     */
    public $modelPropertyName = 'title';
    /**
     * @var string
     */
    public $modelPropertyId = 'id';
    /**
     * @var string
     */
    public $modelPropertyParentId = 'id_parent';
    /**
     * @var string
     */
    public $modelPropertyPosition = 'position';
    /**
     * @var
     */
    public $modelPropertyUrl;
    /**
     * @var string
     */
    public $theme = 'default';
    /**
     * @var
     */
    public $onSelect;
    /**
     * @var
     */
    public $onCreate;
    /**
     * @var
     */
    public $onMove;
    /**
     * @var
     */
    public $onRemove;
    /**
     * @var
     */
    public $onRename;

    /**
     * @var string Url to the assets
     */
    private $_assetsUrl;

    /**
     *
     */
    public function run()
    {
        //if this is an Ajax request, do Ajax and die.
        //It is recommended to change $ajaxUrl to call SimpleTreeWidget::performAjax() directly from a controller.
        if (Yii::app()->request->isAjaxRequest && isset($_POST['simpletree'])) {
            self::performAjax();
            die;
        }
        //register assets
        $this->baseUrl = $this->getAssetsUrl();
        $clientScript = Yii::app()->getClientScript();
        $clientScript->registerCoreScript('jquery');
        $clientScript->registerScriptFile($this->baseUrl . '/_lib/jquery.cookie.js', CClientScript::POS_HEAD);
        $clientScript->registerScriptFile($this->baseUrl . '/_lib/jquery.hotkeys.js', CClientScript::POS_HEAD);
        $clientScript->registerScriptFile($this->baseUrl . '/jquery.jstree.js', CClientScript::POS_HEAD);


        //create container node
        echo "<div id='$this->id'>node</div>";
        $clientScript->registerScript('createJtree', 'jQuery("#' . $this->id . '").jstree({
            "plugins" : [ "themes", "json_data", "ui", "crrm", "cookies", "types", "hotkeys" ],
            "core" : {
                "animation" : 300
            },
            "json_data" : {
                "ajax" : {
                    // the URL to fetch the data
                    "url" : "' . $this->ajaxUrl . '",
                    "data" : function (n) { 
                        return { 
                            "operation" : "get_children", 
                            "id" : n.attr ? n.attr("id").replace("node_","") : ' . $this->modelId . ' ,
                            ' . $this->getEnvironment() . '
                        }; 
                    }
                }
                
            },
            "themes" : {
                "theme" : "' . $this->theme . '",
                "url" : "' . $this->baseUrl . '/themes/' . $this->theme . '/style.css"
            },
            "types" : {
                "valid_children" : [],
                "max_depth" : -2,
                "max_children" : -2,
                "types" : {
                    "readonly" : {
                        "delete_node" : false,
                        "icon" : {"image" : "' . $this->baseUrl . '/themes/readonly.png"},
                    }
                }
            }
        })
        .bind("select_node.jstree", function (e, data){
            ' . $this->onSelect . '
        });', CClientScript::POS_END);
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        $model = is_string($this->model) ? $this->model : get_class($this->model);
        return '
            "model" : "' . $model . '",
            "modelPropertyId" : "' . $this->modelPropertyId . '",
            "modelPropertyParentId" : "' . $this->modelPropertyParentId . '",
            "modelPropertyPosition" : "' . $this->modelPropertyPosition . '",
            "modelPropertyName" : "' . $this->modelPropertyName . '",
            "modelPropertyUrl" : "' . $this->modelPropertyUrl . '",
        ';
    }


    /**
     * @return int
     */
    public function getModelId()
    {
        if (is_object($this->model))
            return ($this->model->{$this->modelPropertyId});
        else
            return 0;
    }

    /**
     * @return string
     */
    private function getAssetsUrl()
    {
        if ($this->_assetsUrl)
            return $this->_assetsUrl;
        return Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets.jstree'), true, -1, YII_DEBUG);
    }

    /**
     *
     */
    static function _get_children()
    {
        $children = array();
        $Model = new $_REQUEST['model'];
        foreach ($Model->findAllByAttributes(array($_REQUEST['modelPropertyParentId'] => $_REQUEST['id'])) AS $k => $Model) {
            if (strpos($_REQUEST['modelPropertyName'], '.') !== false) {
                $modelPropertyName = explode('.', $_REQUEST['modelPropertyName']);
                $children[$k]["data"] = $Model->{$modelPropertyName[0]} ? $Model->{$modelPropertyName[0]}->{$modelPropertyName[1]} : null;
            }
            else
                $children[$k]["data"] = $Model->{$_REQUEST['modelPropertyName']};
            $children[$k]["attr"]["id"] = "node_" . $Model->{$_REQUEST['modelPropertyId']};
            if ($_REQUEST['modelPropertyUrl'])
                $children[$k]["attr"]["href"] = $Model->{$_REQUEST['modelPropertyUrl']};
            if (isset($Model->readonly) && $Model->readonly)
                $children[$k]["attr"]["rel"] = "readonly";
            else
                $children[$k]["attr"]["rel"] = "default";

            //only add a closed symbol if the model has children
            if ($Model->findByAttributes(array($_REQUEST['modelPropertyParentId'] => $Model->{$_REQUEST['modelPropertyId']})))
                $children[$k]["state"] = "closed";
        };

        if (!$_REQUEST['id'])
            $children = array(
                "data" => "root",
                "attr" => array('id' => 0),
                "children" => $children,
                "state" => $children ? 'open' : '',
                "attr" => array("rel" => "readonly")
            );

        echo json_encode($children);
        die;
    }


    /**
     *
     */
    static function performAjax()
    {
        $Model = new $_REQUEST['model'];
        $method = '_' . $_REQUEST['operation'];

        header("HTTP/1.0 200 OK");
        header('Content-type: text/json; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Pragma: no-cache");
        self::$method($_POST);

    }

    /**
     * @param $params
     */
    static function _create_node($params)
    {
        $Model = new $params['model'];
        $Model->$params['modelPropertyParentId'] = $params['id'];
        $Model->$params['modelPropertyName'] = $params['title'];
        @$Model->$params['modelPropertyPosition'] = $params['position'];

        if ($Model->save())
            echo json_encode(array('status' => 1, 'id' => $Model->$params['modelPropertyId']));
        else
            print_r($Model->getErrors());
    }

    /**
     * @param $params
     */
    static function _remove_node($params)
    {
        self::_removeModelRecursively($params);
        echo json_encode(array('status' => 1));
    }

    /**
     * @param $params
     */
    static function _rename_node($params)
    {
        $Model = new $params['model'];
        $Model = $Model->findByPk($params['id']);
        $Model->$params['modelPropertyName'] = $params['title'];
        if ($Model->save())
            echo json_encode(array('status' => 1));
    }


    /**
     * @param $params
     */
    static function _move_node($params)
    {
        $params['ref'] = (int)$params['ref'];

        //get model
        $Model = new $params['model'];
        $Model = $Model->findByPk($params['id']);

        //copy and die?
        if ($params['copy']) {
            $Model = self::_copy_node($Model, $params);
        }

        //get new siblings
        $criteria = new CDbCriteria;
        $criteria->order = $params['modelPropertyPosition'];
        $criteria->condition = $params['modelPropertyParentId'] . '=' . $params['ref'] . ' AND ' . $params['modelPropertyId'] . '!=' . $params['id'];
        $siblings = $Model->findAll($criteria);

        //if item is moved to a higher position ID in it's current folder, make sure to substract it's old position as the item only exists once
        if ($Model->$params['modelPropertyParentId'] == $params['ref'] && $Model->$params['modelPropertyPosition'] < $params['position'])
            $params['position']--;

        //save model
        $Model->$params['modelPropertyPosition'] = $params['position'];
        $Model->$params['modelPropertyParentId'] = $params['ref'];
        $Model->save();

        //assign positions to siblings
        $i = 0;
        foreach ($siblings AS $Sibling) {
            //params position is reserved, so iterate by it
            if ($i == $params['position'])
                $i++;
            $Sibling->$params['modelPropertyPosition'] = $i;
            $Sibling->save();
            $i++;
        }

        echo json_encode(array('status' => 1));
    }

    /**
     * @param $Model
     * @param $params
     * @param bool $inheritPosition
     * @return mixed
     */
    static function _copy_node($Model, $params, $inheritPosition = false)
    {
        $NewModel = new $params['model'];
        $NewModel->attributes = $Model->attributes;

        //copy these, even if they're unsafe values
        $NewModel->{$params['modelPropertyName']} = $Model->{$params['modelPropertyName']};
        $NewModel->{$params['modelPropertyParentId']} = $params['ref'];
        $NewModel->{$params['modelPropertyPosition']} = $inheritPosition ? $Model->{$params['modelPropertyPosition']} : $params['position'];

        if ($NewModel->save()) {
            //copy children
            foreach ($NewModel->findAllByAttributes(array($params['modelPropertyParentId'] => $Model->{$params['modelPropertyId']})) AS $Child) {
                $params['ref'] = $NewModel->{$params['modelPropertyId']};
                self::_copy_node($Child, $params, true);
            }
            return $NewModel;
        }
    }

    /**
     * @param $params
     * @return string
     */
    static function _removeModelRecursively($params)
    {
        if (!$params['id'] || preg_match('/[^\d]/', $params['id']))
            return json_encode(array('status' => 0));

        $Model = new $params['model'];
        $Model = $Model->findByPk($params['id']);
        foreach ($Model->findAllByAttributes(array($params['modelPropertyParentId'] => $params['id'])) AS $Child) {
            $params['id'] = $Child->$params['modelPropertyId'];
            self::_removeModelRecursively($params);
        }
        $Model->delete();
    }
}


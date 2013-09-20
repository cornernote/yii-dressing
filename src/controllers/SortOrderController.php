<?php

/**
 * SortOrderController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class SortOrderController extends WebController
{

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('order', 'orderReset', 'moveTop', 'moveBottom'),
                'users' => array('*'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * Handles the ordering of model.
     * @param $model
     */
    public function actionOrder($model)
    {
        //$_POST = $_GET;

        // Handle the POST request data submission
        if (Yii::app()->request->isPostRequest && isset($_POST['Order'])) {
            $ids = explode(',', $_POST['Order']);
            $i = count($ids);
            foreach ($ids as $id) {
                $sortOrder = SortOrder::model()->find('model=:model AND model_id=:model_id', array('model' => $model, 'model_id' => $id));
                if (!$sortOrder) {
                    $sortOrder = new SortOrder;
                    $sortOrder->model = $model;
                    $sortOrder->model_id = $id;
                }
                $sortOrder->sort_order = $i;
                $sortOrder->save();
                $i--;
            }
        }
    }

    /**
     * Resets the order of a sorted list
     * @param $model
     */
    public function actionOrderReset($model)
    {
        $sortOrders = SortOrder::model()->findAll('model=:model', array('model' => $model));
        foreach ($sortOrders as $sortOrder) {
            $sortOrder->delete();
        }
        $this->redirect(ReturnUrl::getUrl());
    }

    /**
     * Move a model to the top of a sorted list.
     * @param $id
     * @param $model
     */
    public function actionMoveTop($id, $model)
    {
        $sortOrder = SortOrder::model()->find('model=:model AND model_id=:model_id', array('model' => $model, 'model_id' => $id));
        if (!$sortOrder) {
            $sortOrder = new SortOrder;
            $sortOrder->model = $model;
            $sortOrder->model_id = $id;
        }
        $sortOrder->sort_order = 9999;
        $sortOrder->save();
        $this->redirect(ReturnUrl::getUrl());
    }

    /**
     * @param $id
     * @param $model
     */
    public function actionMoveBottom($id, $model)
    {
        $sortOrder = SortOrder::model()->find('model=:model AND model_id=:model_id', array('model' => $model, 'model_id' => $id));
        if (!$sortOrder) {
            $sortOrder = new SortOrder;
            $sortOrder->model = $model;
            $sortOrder->model_id = $id;
        }
        $sortOrder->sort_order = 1;
        $sortOrder->save();
        $this->redirect(ReturnUrl::getUrl());
    }

}

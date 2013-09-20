<?php

/**
 * ToolController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class ToolController extends WebController
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
                'actions' => array('clearCache', 'clearCacheModel', 'clearAsset', 'generateProperties'),
                'roles' => array('admin'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * @return array
     */
    public function actions()
    {
        return array(
            'generateProperties' => array(
                'class' => 'actions.GeneratePropertiesAction',
            ),
        );
    }

    /**
     *
     */
    public function actionClearCache()
    {
        // yii cache
        cache()->flush();
        // model cache
        ModelCache::model()->flush();
        // assets
        Helper::removeDirectory(app()->getAssetManager()->basePath, false);
        // all done
        user()->addFlash(t('Server cache has been cleared.'), 'success');
        $this->redirect(ReturnUrl::getUrl());
    }

    /**
     * Clears cache for a single model
     *
     * @param $model
     * @param $id
     */
    public function actionClearCacheModel($model, $id)
    {
        /* @var $modelInstance ActiveRecord */
        $modelInstance = ActiveRecord::model($model)->findByPk($id);
        if ($modelInstance) {
            $modelInstance->clearCache();
            user()->addFlash(strtr(t('Cache cleared for :model :id.'), array(
                ':model' => $model,
                ':id' => $id,
            )), 'success');
        }
        else {
            user()->addFlash(strtr(t('Could not find :model with ID :id.'), array(
                ':model' => $model,
                ':id' => $id,
            )), 'success');
        }
        $this->redirect(ReturnUrl::getUrl());
    }

    /**
     *
     */
    public function actionClearAsset()
    {
        Helper::removeDirectory(Yii::app()->getAssetManager()->getBasePath(), false);
        user()->addFlash(t('Assets have been cleared'), 'success');
        $this->redirect(ReturnUrl::getUrl());
    }

}


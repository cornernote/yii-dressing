<?php
/**
 * YdController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdController extends CController
{

    /**
     * @return array action filters
     */
    //public function filters()
    //{
    //    return array(
    //        'accessControl',
    //        'webUserType' => array('dressing.components.YdWebUserTypeFilter'),
    //    );
    //}


    /**
     * Allows loading view from dressing.views when application, theme and module views are unavailable.
     *
     * @param string $viewName
     * @param string $viewPath
     * @param string $basePath
     * @param null $moduleViewPath
     * @return mixed
     */
    public function resolveViewFile($viewName, $viewPath, $basePath, $moduleViewPath = null)
    {
        $viewFile = parent::resolveViewFile($viewName, $viewPath, $basePath, $moduleViewPath);
        if ($viewFile)
            return $viewFile;

        // if not found in app, try to find in dressing.views
        $path = Yii::getPathOfAlias('dressing.views');
        $appViewPath = Yii::app()->getViewPath();
        $viewPath = $path . str_replace($appViewPath, '', $viewPath);
        $basePath = $path . str_replace($appViewPath, '', $basePath);
        return parent::resolveViewFile($viewName, $viewPath, $basePath, null);
    }


}

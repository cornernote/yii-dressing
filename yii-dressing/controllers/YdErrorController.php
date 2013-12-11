<?php

/**
 * YdErrorController
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.controllers
 */
class YdErrorController extends YdWebController
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
                'actions' => array('index', 'view', 'clear'),
                'roles' => array('admin'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * @param string $view the view to be rendered
     * @return bool
     */
    public function beforeRender($view)
    {
        $this->addBreadcrumb(Yii::t('dressing', 'Tools'), array('/tool/index'));
        if (in_array($view, array('view'))) {
            $this->addBreadcrumb(Yii::t('dressing', 'Errors'), array('/error/index'));
        }
        return parent::beforeRender($view);
    }

    /**
     *
     */
    public function actionIndex($ignoreCodes = false)
    {
        $dir = app()->getRuntimePath() . '/errors';
        $errors = $this->getErrors();
        if (!$ignoreCodes) {
            $ignoreCodes = 404;
        }
        if ($ignoreCodes) {
            //none not in the list
            if (stripos($ignoreCodes, 'none') === false) {
                $ignoreCodes = explode('-', $ignoreCodes);
            }
            //if none in the list simply ignore all errors
            else {
                $ignoreCodes = array();
            }
        }
        $filteredErrors = array();
        foreach ($errors as $k => $v) {
            $error = substr($v, strlen($dir) + 1);
            $auditInfo = str_replace(array('archive/', 'audit-', '.html'), '', $error);
            $errorCode = '';
            if (strpos($auditInfo, '-')) {
                list($auditId, $errorCode) = explode('-', $auditInfo);
            }
            else {
                $auditId = $auditInfo;
            }
            if ($ignoreCodes && in_array($errorCode, $ignoreCodes)) {
                continue;
            }

//            $errors[$k] = substr($v, strlen($dir) + 1);
            $filteredErrors[$k] = substr($v, strlen($dir) + 1);
        }
        rsort($errors);
        $this->render('index', array(
            'errors' => $filteredErrors,
        ));
    }


    /**
     * @param $error
     * @param null $archive
     */
    public function actionView($error, $archive = null)
    {
        $path = app()->getRuntimePath() . '/errors/';
        if ($archive)
            $path .= 'archive/';
        $path .= $error;

        $auditInfo = str_replace(array('archive/', 'audit-', '.html'), '', $error);
        $errorCode = '';
        if (strpos($auditInfo, '-')) {
            list($auditId, $errorCode) = explode('-', $auditInfo);
            if ($errorCode) {
                $errorCode = $errorCode . ' - ';
            }
        }
        else {
            $auditId = $auditInfo;
        }
        $audit = Audit::model()->findByPk($auditId);
        $auditLink = '';
        if ($audit) {
            $auditLink = $audit->getLink() . ' ';
        }
        $contents = file_get_contents($path);
        $contents = str_replace('class="container"', 'class="container-fluid"', $contents);
        if (strpos($contents, '<body>')) {
            $contents = str_replace('</h1>', ' - ' . $errorCode . $auditId . '</h1>' . '<h3> ' . $auditLink . ' logged on ' . date('Y-m-d H:i:s', filemtime($path)) . '</h3>', $contents);
            $contents = StringHelper::getBetweenString($contents, '<body>', '</body>');
            Yii::app()->clientScript->registerCss('error', file_get_contents(dirname($this->getViewFile('index')) . '/view.css'));
        }
        else {
            $contents = '<h1>' . $errorCode . $auditId . '</h1>' . '<h3> ' . $auditLink . ' logged on ' . date('Y-m-d H:i:s', filemtime($path)) . '</h3><pre>' . $contents . '</pre>';
        }
        $this->pageTitle = Yii::t('dressing', 'Error') . ' ' . $error;
        $this->renderText($contents);
        app()->end();
    }

    /**
     *
     */
    public function actionClear()
    {
        foreach ($this->getErrors() as $error) {
            unlink($error);
        }
        Yii::app()->user->addFlash('Errors cleared ', 'success');
        $this->redirect(array('error/index'));
    }

    /**
     * @return array
     */
    private function getErrors()
    {
        $dir = app()->getRuntimePath() . '/errors';
        $errors = array();

        // get new errors
        $_errors = glob($dir . '/' . '*.html');
        if ($_errors) $errors = array_merge($errors, $_errors);

        // get archived errors
        $_errors = glob($dir . '/archive/' . '*.html');
        if ($_errors) $errors = array_merge($errors, $_errors);

        return $errors;
    }

}


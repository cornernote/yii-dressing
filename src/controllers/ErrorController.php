<?php

/**
 * ErrorController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class ErrorController extends WebController
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
     *
     */
    public function actionIndex()
    {
        $dir = app()->getRuntimePath() . '/errors';
        $errors = $this->getErrors();
        foreach ($errors as $k => $v) {
            $errors[$k] = substr($v, strlen($dir) + 1);
        }
        rsort($errors);
        $this->render('index', array(
            'errors' => $errors,
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
            cs()->registerCss('error', file_get_contents(dirname($this->getViewFile('index')) . '/view.css'));
        }
        else {
            $contents = '<h1>' . $errorCode . $auditId . '</h1>' . '<h3> ' . $auditLink . ' logged on ' . date('Y-m-d H:i:s', filemtime($path)) . '</h3><pre>' . $contents . '</pre>';
        }
        $this->breadcrumbs = array(
            t('Error List') => array('/error/index'),
            t('Error') . ' ' . $error,
        );
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
        user()->addFlash('Errors cleared ', 'success');
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


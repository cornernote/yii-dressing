<?php
/**
 *
 */
class YdApiController extends YdController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/json';

    /**
     * @var
     */
    public $HTTPStatus;

    /**
     * Initializes the controller.
     * This method is called by the application before the controller starts to execute.
     * You may override this method to perform the needed initialization for the controller.
     */
    public function init()
    {
        parent::init();

        // custom error action
        Yii::app()->errorHandler->errorAction = '/' . $this->id . '/error';

        // do not redirect when not logged in
        Yii::app()->user->loginUrl = null;

        // allow login from any url
        if (isset($_SERVER['PHP_AUTH_USER']) || isset($_SERVER['PHP_AUTH_PW'])) {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];

            // allow a secure link to api-login
            $identity = new UserIdentity($username, $password);
            if ($identity->authenticateApi()) {
                Yii::app()->user->login($identity, $duration = 0);
            }
        }

        // ensure the user is an api login
        if (!Yii::app()->user->isGuest && !Yii::app()->user->getState('UserIdentity.api')) {
            throw new CHttpException(403, Yii::t('dressing', 'Please login to API.'));
        }
    }

    /**
     * Custom error handler for restfull Errors
     */
    public function actionError()
    {
        if ($error = app()->errorHandler->error) {
            if (app()->request->isAjaxRequest)
                echo $error['message'];
            else {
                $this->HTTPStatus = $this->getHttpStatus($error['code']);
                if ($this->HTTPStatus == $this->getHttpStatus(200))
                    $this->HTTPStatus = $this->getHttpStatus(500);
                $this->renderJson(array(
                    'success' => false,
                    'message' => $error['message'],
                    'data' => array(
                        'errorCode' => $error['code'],
                    ),
                ));
            }
        }
    }

    /**
     * Get HTTP Status Headers From code
     * @param $statusCode
     * @return string
     */
    public function getHttpStatus($statusCode)
    {
        switch ($statusCode) {
            case '200':
                return 'HTTP/1.1 200 OK';
            case '201':
                return 'HTTP/1.1 201 Created';
            case '401':
                return 'HTTP/1.1 401 Unauthorized';
            case '404':
                return 'HTTP/1.1 404 Not Found';
            case '406':
                return 'HTTP/1.1 406 Not Acceptable';
            case '500':
                return 'HTTP/1.1 500 Internal Server Error';
            default:
                return 'HTTP/1.1 200 OK';
        }
    }

    /**
     * @param $id
     * @param bool|string $model
     * @return ActiveRecord
     * @throws CHttpException
     */
    public function loadModel($id, $model = false)
    {
        if (!$model)
            $model = str_replace('ApiController', '', get_class($this));
        if ($this->loadModel === null) {
            $this->loadModel = CActiveRecord::model($model)->findbyPk($id);
            if ($this->loadModel === null)
                throw new CHttpException(404, Yii::t('dressing', 'The requested model does not exist.'));
        }
        return $this->loadModel;
    }

}
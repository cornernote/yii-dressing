<?php

/**
 * AttachmentController
 *
 * @package app.controller
 * @author Brett O'Donnell <brett@mrphp.com.au>
 */
class AttachmentController extends YdWebController
{

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        // default public rules
        $public = array('allow',
            'actions' => array('dummy'),
            'users' => array('*'),
        );

        //if ($this->allowCreateAccess()) {
        //    $public['actions'][] = 'create';
        //}

        if ($this->allowViewAccess()) {
            $public['actions'][] = 'view';
            $public['actions'][] = 'preview';
        }

        // return the rules
        return array(
            $public,
            array('allow',
                'actions' => array('order', 'create', 'view', 'update', 'delete', 'preview'),
                'roles' => array('staff',),
            ),
            array('allow',
                'actions' => array('undelete'),
                'roles' => array('admin'),
            ),
            array('allow',
                'actions' => array('view', 'preview'),
                'roles' => array('lcd'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    private function allowCreateAccess()
    {
        // allow create from swfupload
        // swfupload is disabled for now
        //if (isset($_GET['key']) && isset($_GET['time']) && isset($_GET['model']) && isset($_GET['foreign_key']) && isset($_GET['user_id'])) {
        //    if (($_GET['time'] > time() - 60) && $_GET['key'] == md5('s3creth#sh' . $_GET['time'] . $_GET['model'] . $_GET['foreign_key'] . $_GET['user_id'])) {
        //        return true;
        //    }
        //}
        return false;
    }

    private function allowViewAccess()
    {
        // this is only for view access
        if ($this->action->id != 'view' || !isset($_GET['id'])) {
            return false;
        }

        $attachment = YdAttachment::model()->findByPk((int)$_GET['id']);

        // allow lookup and company logo
        if (in_array($attachment->model, array('Lookup', 'Company-logo'))) {
            return true;
        }

        // allow if they have a valid attachment key
        if (Yii::app()->user->getState('attachmentViewKey.' . $attachment->id)) {
            return true;
        }

        // do not allow
        return false;
    }


    /**
     * View a file
     * @param $id
     * @param null $thumb
     * @param null $dl
     * @param null $cache
     * @throws CHttpException
     * @throws Exception
     */
    public function actionPreview($id, $thumb, $dl = null, $cache = null)
    {
        $attachment = YdAttachment::model()->findByPk((int)$id);
        $this->render('dressing.views.attachment.preview', array(
            'attachment' => $attachment,
            'thumb' => $thumb,
        ));
    }

    /**
     * View a file
     * @param $id
     * @param null $thumb
     * @param null $dl
     * @param null $cache
     * @throws CHttpException
     * @throws Exception
     */
    public function actionView($id, $thumb = null, $dl = null, $cache = null)
    {
        $attachment = YdAttachment::model()->findByPk((int)$id);
        if ($thumb) {
            $size = explode('x', $thumb);
            $thumbFilename = $attachment->getAttachmentPath() . '/' . $attachment->id . '.' . urlencode($thumb) . '.jpg';

            // generate thumb
            if (!$attachment->thumb($thumbFilename, $size)) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }

            // do not public cache attachments over 50Kb
            if (filesize($thumbFilename) > (1024 * 50))
                $cache = false;
            if ($cache) {
                // cannot use Yii::app()->request->scriptFile with a symlink
                $filename = dirname(Yii::app()->request->scriptFile) . DIRECTORY_SEPARATOR . 'attachment' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'id' . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . urlencode($thumb) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . $cache;
                if (!file_exists(dirname($filename))) {
                    YdFileHelper::createDirectory(dirname($filename), 0777, true);
                }
                copy($thumbFilename, $filename);
            }

            // serve file
            if (file_exists($thumbFilename)) {
                header('Last-Modified: ' . date('c', filemtime($thumbFilename)));
                header('Cache-Control: max-age=86400');
                header('Content-Type: image/jpg');
                readfile($thumbFilename);
            }
        }
        else {
            $file = $attachment->getAttachmentFile();
            // do not public cache attachments over 10Kb
            if ($file) {
                if (filesize($file) > (1024 * 10))
                    $cache = false;
                if ($cache) {
                    $filename = dirname(Yii::app()->basePath) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'attachment' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'id' . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . $cache;
                    if (!file_exists(dirname($filename))) {
                        YdFileHelper::createDirectory(dirname($filename), 0777, true);
                    }
                    copy($file, $filename);
                }
            }
            else {
                throw new Exception('AttachmentController: Could not find file in path: ' . $attachment->getAttachmentPath() . ' id is ' . $attachment->id . ' extensions is ' . $attachment->extension);
            }

            // serve file
            if (file_exists($file)) {
                if ($attachment->filetype == 'application/octet-stream') {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $attachment->filetype = finfo_file($finfo, $file);
                    finfo_close($finfo);
                    $attachment->save();
                }
                if ($dl) {
                    header('Content-disposition: attachment; filename=' . $attachment->filename . '.' . $attachment->extension);
                }
                header('Content-Type: ' . $attachment->filetype);
                readfile($file);
                Yii::app()->end();
            }
        }
    }

    /**
     * Creates a new model.
     */
    public function actionCreate()
    {
        $attachment = new YdAttachment('create');

        if (isset($_GET['YdAttachment'])) {
            $attachment->attributes = $_GET['YdAttachment'];
        }

        $this->performAjaxValidation($attachment, 'attachment-form');
        if (isset($_POST['YdAttachment']) || isset($_FILES['Filedata'])) {

            // restructure swfupload posted file
            if (isset($_FILES['Filedata'])) {
                $_POST['YdAttachment'] = array(
                    'filename' => $_POST['Filename'],
                    'notes' => '',
                );
                $_FILES['YdAttachment'] = array(
                    'name' => array(
                        'filename' => $_FILES['Filedata']['name'],
                    ),
                    'type' => array(
                        'filename' => $_FILES['Filedata']['type'],
                    ),
                    'tmp_name' => array(
                        'filename' => $_FILES['Filedata']['tmp_name'],
                    ),
                    'error' => array(
                        'filename' => $_FILES['Filedata']['error'],
                    ),
                    'size' => array(
                        'filename' => $_FILES['Filedata']['size'],
                    ),
                );
                $attachment->model = $_GET['model'];
                $attachment->foreign_key = $_GET['foreign_key'];
                $attachment->created_by = $_GET['user_id'];
                $attachment->modified_by = $_GET['user_id'];
            }
            $attachment->attributes = $_POST['YdAttachment'];
            $saved = $attachment->save();

            if (isset($_FILES['Filedata'])) {
                if (!$saved) {
                    if (!empty($attachment->errors)) {
                        print_r($attachment->errors);
                    }
                }
                else {
                    echo 'FILEID:' . $attachment->id;
                }
                Yii::app()->end();
            }
            else {
                if ($saved) {
                    Yii::app()->user->addFlash('Attachment has been created', 'success');
                    if (!isAjax())
                        $this->redirect(Yii::app()->returnUrl->getUrl());
                }
                else {
                    if (!$attachment->getErrorString()) {
                        Yii::app()->user->addFlash('Could not create Attachment', 'error');
                    }

                }
            }

        }

        $this->render('dressing.views.attachment.create', array(
            'attachment' => $attachment,
        ));
    }

    /**
     * Updates a particular note
     * @param integer $id the ID of the note to be updated
     */
    public function actionUpdate($id)
    {
        $attachment = $this->loadModel($id, 'YdAttachment');

        $this->performAjaxValidation($attachment, 'attachment-form');

        if (isset($_POST['YdAttachment'])) {
            $attachment->attributes = $_POST['YdAttachment'];
            if ($attachment->save()) {
                $this->redirect(Yii::app()->returnUrl->getUrl());
            }
        }

        $this->render('dressing.views.attachment.update', array(
            'attachment' => $attachment,
        ));
    }

    /**
     * Handles the ordering of attachments.
     */
    public function actionOrder()
    {
        // Handle the POST request data submission
        if (app()->request->isPostRequest && isset($_POST['Order'])) {
            // Since we converted the Javascript array to a string,
            // convert the string back to a PHP array
            $attachments = explode(',', $_POST['Order']);

            for ($i = 0; $i < sizeof($attachments); $i++) {
                if ($attachment = YdAttachment::model()->findbyPk($attachments[$i])) {
                    $attachment->weight = $i;
                    $attachment->save();
                }
            }
        }
    }

    /**
     * Deletes a particular model.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id = null)
    {
        $task = YdHelper::getSubmittedField('task', 'YdAttachment') == 'undelete' ? 'undelete' : 'delete';
        if (YdHelper::getSubmittedField('confirm', 'YdAttachment')) {
            foreach ($this->getGridIds($id) as $_id) {
                $attachment = YdAttachment::model()->findByPk($_id);

                // check access
                if (!$attachment->checkUserAccess(Yii::app()->user->id)) {
                    continue;
                }
                call_user_func(array($user, $task));
                Yii::app()->user->addFlash(strtr('Attachment :name has been :tasked.', array(
                    ':name' => $attachment->getName(),
                    ':tasked' => $task . 'd',
                )), 'success');
            }
            $this->redirect(Yii::app()->returnUrl->getUrl(Yii::app()->user->getState('index.attachment', array('/attachment/index'))));
        }

        $this->render('dressing.views.attachment.delete', array(
            'id' => $id,
            'task' => $task,
        ));
    }

}

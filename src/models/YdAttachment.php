<?php

/**
 * --- BEGIN GenerateProperties ---
 *
 * This is the model class for table 'attachment'
 *
 * @method Attachment with() with()
 * @method Attachment find() find($condition, array $params = array())
 * @method Attachment[] findAll() findAll($condition = '', array $params = array())
 * @method Attachment findByPk() findByPk($pk, $condition = '', array $params = array())
 * @method Attachment[] findAllByPk() findAllByPk($pk, $condition = '', array $params = array())
 * @method Attachment findByAttributes() findByAttributes(array $attributes, $condition = '', array $params = array())
 * @method Attachment[] findAllByAttributes() findAllByAttributes(array $attributes, $condition = '', array $params = array())
 * @method Attachment findBySql() findBySql($sql, array $params = array())
 * @method Attachment[] findAllBySql() findAllBySql($sql, array $params = array())
 *
 * Properties from table fields
 * @property integer $id
 * @property string $model
 * @property integer $model_id
 * @property string $filename
 * @property string $extension
 * @property string $filetype
 * @property integer $filesize
 * @property string $notes
 * @property integer $sort_order
 * @property datetime $created
 * @property datetime $deleted
 *
 * --- END GenerateProperties ---
 */
class YdAttachment extends YdActiveRecord
{

    /**
     * @var CUploadedFile  used to store the file object
     */
    private $_file;

    /**
     * @var bool true if we are expecting a user upload
     */
    public $handleFileUpload = true;

    /**
     * @var array
     */
    public static $imageExtensions = array('jpg', 'gif', 'png', 'jpeg');

    /**
     * @var array
     */
    public static $pdfExtensions = array('pdf');

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return Attachment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array containing model behaviors
     */
    public function behaviors()
    {
        return array(
            'AuditBehavior' => 'dressing.behaviors.YdAuditBehavior',
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            // search fields
            array('id,model,model_id,notes,filename', 'safe', 'on' => 'search'),

            // model
            array('model', 'safe', 'on' => 'create'),

            // model_id
            array('model_id', 'safe', 'on' => 'create'),

            // notes
            array('notes', 'type', 'type' => 'string'),

            // filename
            array('filename', 'file', 'types' => 'jpg, gif, png, pdf, zip', 'on' => 'create'),
            array('filename', 'type', 'type' => 'string'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('dressing', 'ID'),
            'filename' => Yii::t('dressing', 'File'),
            'notes' => Yii::t('dressing', 'Notes'),
        );
    }

    /**
     * Returns a URL to this model
     *
     * @param string $action
     * @param array $params
     * @return string
     */
    public function getUrl($action = 'view', $params = array())
    {
        return array_merge(array(
            '/attachment/' . $action,
            'id' => $this->id,
            'file' => $this->filename,
        ), (array)$params);
    }

    /**
     * Actions to be performed before the model is validated
     * @return bool
     */
    protected function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        // handle the file upload
        if ($this->isNewRecord && $this->handleFileUpload) {
            $this->_file = CUploadedFile::getInstance($this, 'filename');
            $fileInfo = pathinfo($this->_file->name);
            $this->filename = $this->_file->name;
            $this->extension = $fileInfo['extension'];
            $this->filetype = $this->_file->type;
            $this->filesize = filesize($this->_file->tempName);
        }

        return true;
    }

    /**
     * Actions to be performed after the model is saved
     */
    protected function afterSave()
    {
        parent::afterSave();

        // handle the file upload
        if ($this->isNewRecord && $this->handleFileUpload) {
            $fileInfo = pathinfo($this->_file->name);
            $file = $this->getAttachmentPath() . '/' . $this->id . '.' . $fileInfo['extension'];
            if (!file_exists(dirname($file))) {
                mkdir(dirname($file), 0777, true);
            }
            $this->_file->saveAs($file);
        }

        // clear cache for jobs and items
        if (in_array($this->model, array('Job', 'Item'))) {
            $model = ActiveRecord::model($this->model)->findByPk($this->model_id);
            if ($model) {
                $model->clearCache();
            }
        }

        $this->handleFileUpload = true;
    }

    /**
     * @return string
     */
    function getAttachmentPath()
    {
        $folder = dirname(Yii::app()->basePath) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'attachment' . DIRECTORY_SEPARATOR . $this->model . DIRECTORY_SEPARATOR . $this->model_id;
        //$path = $folder . DIRECTORY_SEPARATOR . $this->filename;
        if (!file_exists($folder)) {
            $success = @mkdir($folder, 0777, true);
            if (!$success) {
                throw new CException("could not mkdir [$folder]");
            }
        }
        return $folder;
    }

    /**
     * @return string
     */
    function getAttachmentFile()
    {
        $dir = $this->getAttachmentPath();
        $file = $dir . '/' . $this->id . '.' . $this->extension;
        if (!file_exists($file)) {
            $file = $dir . '/' . $this->filename;
        }
        if (!file_exists($file) || !filesize($file)) {
            return false;
        }
        return $file;
    }

    /**
     * @param string $size
     * @param null $url
     * @return string
     */
    function getThumb($size = '60x60', $url = null)
    {
        return self::getStaticThumb($size, strtotime($this->created), $this->id, $this->filename, $url);
    }

    /**
     * Static method to get a thumb
     * @static
     * @param $size
     * @param $created
     * @param $id
     * @param $filename
     * @param $url
     * @return string
     */
    static function getStaticThumb($size, $created, $id, $filename, $url)
    {
        $wh = explode('x', $size);
        $cache = ($wh[0] <= 100 && $wh[1] <= 100) ? '/cache/' . md5(Yii::app()->params['hashKey']) . md5($created) : '';
        if ($cache) {
            $thumb = CHtml::image(Yii::app()->request->baseUrl . '/attachment/view/id/' . $id . '/thumb/' . $size . $cache);
        }
        else {
            $thumb = CHtml::image(Yii::app()->request->baseUrl . '/attachment/view/id/' . $id . '/thumb/' . $size . '/filename/' . $filename);
        }
        if ($url) {
            $thumb = CHtml::link($thumb, $url);
        }
        return $thumb;
    }

    /**
     *
     * @param $size
     * @return bool|string
     */
    public function getPopup($size)
    {
        $link = false;
        Yii::app()->user->setState('attachmentViewKey.' . $this->id, true);
        if (in_array($this->extension, array('jpg', 'gif', 'png'))) {
            $img = CHtml::image(Yii::app()->request->baseUrl . '/attachment/view/id/' . $this->id . '/thumb/' . $size . '/' . $this->filename);
            $url = Yii::app()->request->baseUrl . '/attachment/view/id/' . $this->id . '/thumb/800x800/' . $this->filename;
            $link = CHtml::link($img, $url, array('data-toggle' => 'modal'));
        }
        elseif (in_array($this->extension, array('pdf'))) {
            $img = CHtml::image(Yii::app()->request->baseUrl . '/attachment/view/id/' . $this->id . '/thumb/' . $size . '/' . $this->filename);
            $url = array('/attachment/view', 'id' => $this->id, 'dl' => '1');
            $link = CHtml::link($img, $url);
        }
        return $link;
    }


    /**
     * Generate a thumbnail of an attachment
     * @param $file
     * @param $size
     * @return bool
     * @throws CException
     */
    public function thumb($file, $size)
    {
        if (!$file) {
            return false;
        }
        if (file_exists($file)) {
            return true;
        }
        if (!file_exists(dirname($file)))
            mkdir(dirname($file), 0777, true);

        // find the image
        $image = $this->getAttachmentFile();
        $defaultImage = dirname(Yii::app()->basePath) . '/data/attachment/default.jpg';
        if (!$image) {
            if (YII_DEBUG)
                throw new CException('Cannot find source image (' . $image . ').');
            $image = $defaultImage;
        }

        $fileInfo = pathinfo($image);
        if ($fileInfo['extension'] != 'pdf') {
            $imageSize = getimagesize($image);
            if ($imageSize[0] < $size[0])
                $size[0] = $imageSize[0];
            if ($imageSize[1] < $size[1])
                $size[1] = $imageSize[1];
        }
        require_once(Yii::getPathOfAlias('vendor') . DIRECTORY_SEPARATOR . 'phpThumb' . DIRECTORY_SEPARATOR . 'phpThumb.php');
        $phpThumb = new phpThumb;
        $phpThumb->setSourceFilename($image);
        $phpThumb->setParameter('config_imagemagick_path', 'convert');
        $phpThumb->setParameter('config_allow_src_above_docroot', 'convert');
        $phpThumb->setParameter('aoe', false);
        $phpThumb->setParameter('w', $size[0]);
        $phpThumb->setParameter('h', $size[1]);
        $phpThumb->setParameter('f', 'JPG'); // set the output format
        $phpThumb->setParameter('far', 'C'); // scale outside
        $phpThumb->setParameter('bg', 'FFFFFF'); // scale outside
        if (!$phpThumb->GenerateThumbnail()) {
            $phpThumb->setSourceFilename($defaultImage);
            if (!$phpThumb->GenerateThumbnail()) {
                throw new CException('Cannot generate thumbnail from image (' . $image . ').');
            }
        }
        if (!$phpThumb->RenderToFile($file)) {
            throw new CException('Cannot save thumbnail (' . $file . ').');
        }
        return true;
    }


}
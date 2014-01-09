<?php

/**
 *
 */
class YdCKEditor extends CInputWidget
{

    /**
     * @var
     */
    public $defaultValue;
    /**
     * @var
     */
    public $config;

    /**
     * @var
     */
    protected $url;

    /**
     * @var
     */
    protected $path;


    /**
     *
     */
    public function init()
    {
        $this->path = Yii::getPathOfAlias('vendor.cornernote.ckeditor-assets');
        $this->url = app()->assetManager->publish($this->path, false, -1, YII_DEBUG);
        if (substr($this->id, 0, 2) == 'yw' && $this->hasModel()) {
            $this->id = get_class($this->model) . '[' . $this->attribute . ']';
        }

        if (!isset($this->config['toolbar'])) {
            $this->config['toolbar'] = array(
                array('Source', 'RemoveFormat'),
                array('Bold', 'Italic', 'Underline', 'Strike', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'HorizontalRule'),
                array('Image', 'Link', 'Unlink', 'Anchor'),
                array('Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'),
                array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'),
            );
        }
        if (!isset($this->config['height'])) {
            $this->config['height'] = '400px';
        }
        if (!isset($this->config['width'])) {
            $this->config['width'] = '100%';
        }
        parent::init();
    }

    /**
     *
     */
    public function run()
    {
        require_once($this->path . '/ckeditor.php');
        $oCKeditor = new CKeditor($this->id);
        $oCKeditor->basePath = $this->url . '/';
        foreach ($this->config as $key => $value) {
            $oCKeditor->config[$key] = $value;
        }
        $oCKeditor->editor($this->id, $this->defaultValue);
    }

}
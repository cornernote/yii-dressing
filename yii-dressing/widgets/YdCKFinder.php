<?php

/**
 *
 */
class YdCKFinder extends CInputWidget
{
    /**
     * @var
     */
    public $name;
    /**
     * @var array
     */
    public $htmlOptions = array();
    /**
     * @var array
     */
    public $buttonHtmlOptions = array();
    /**
     * @var array
     */
    public $allowedExtensions = array();
    /**
     * @var array
     */
    public $deniedExtensions = array();
    /**
     * @var int
     */
    public $maxSize = 0;
    /**
     * @var
     */
    protected $directory;
    /**
     * @var
     */
    protected $url;
    /**
     * @var
     */
    protected $resourceTypes;
    /**
     * @var
     */
    protected $path;

    /**
     *
     */
    public function init()
    {
        $this->directory || $this->directory = app()->getRuntimePath() . '/ck_uploads/';
        if (!file_exists($this->directory)) {
            mkdir($this->directory, 0755, true);
        }

        $ckFinderPath = Yii::getPathOfAlias('vendor') . '/cornernote/ckfinder-assets/ckfinder';
        $this->path = app()->assetManager->publish($ckFinderPath, false, -1, YII_DEBUG);

        if (!$this->resourceTypes) {
            $this->resourceTypes[] = array(
                'name' => t('CK Uploads'), // Single quotes not allowed
                'url' => $this->url,
                'directory' => $this->directory,
                'maxSize' => $this->maxSize,
                'allowedExtensions' => is_array($this->allowedExtensions) ? implode(',', $this->allowedExtensions) : $this->allowedExtensions,
                'deniedExtensions' => is_array($this->deniedExtensions) ? implode(',', $this->deniedExtensions) : $this->deniedExtensions,
            );
        }

        $lo_session = new CHttpSession;
        $lo_session->open();
        $lo_session['ck_auth'] = true;
        $lo_session['ck_upload_path'] = $this->directory . '/';
        $lo_session['ck_upload_url'] = $this->url . '/';
        $lo_session['ck_resource'] = $this->resourceTypes;

        parent::init();
    }

    /**
     *
     */
    public function run()
    {
        $cs = app()->clientScript;
        $cs->registerScriptFile($this->path . '/ckfinder.js');

        // register the scripts
        ob_start();
        ?>
        <script type="text/javascript">
            function <?php echo $this->id; ?>_BrowseServer() {
                var finder = new CKFinder();
                finder.selectActionFunction = function (fileUrl) {
                    fileUrl = fileUrl.replace('<?php echo $this->url; ?>', '');
                    document.getElementById('<?php echo $this->id . '_' . $this->name; ?>').value = fileUrl;
                }
                finder.popup();
            }
        </script>

        <?php
        $contents = ob_get_clean();
        $contents = str_replace(array('<script>', '<script type="text/javascript">', '</script>'), '', $contents);
        $cs->registerScript($this->id . '_ckfinder', $contents, CClientScript::POS_END);

        // <input id="xMyField" name="MyField" type="text" size="60"/>
        if (empty($this->htmlOptions['id']))
            $this->htmlOptions['id'] = $this->id . '_' . $this->name;
        echo CHtml::textField($this->name, '', $this->htmlOptions);

        // <input type="button" value="Select" onclick="BrowseServer();"/>
        $this->buttonHtmlOptions['onclick'] = $this->id . '_BrowseServer();';
        echo CHtml::button(t('Select'), $this->buttonHtmlOptions);
    }

}
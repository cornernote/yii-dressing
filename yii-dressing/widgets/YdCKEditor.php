<?php

/**
 *
 */
class YdCKEditor extends CWidget
{

    /**
     * @var string
     */
    public $selector = 'textarea.ckeditor';

    /**
     * @var
     */
    public $config = array();

    /**
     * @var array
     */
    public $defaultConfig = array(
        //'toolbar_Full' => array(
        //    array('name' => 'document', 'items' => array('Source', '-', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', '-', 'Templates')),
        //    array('name' => 'clipboard', 'items' => array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo')),
        //    array('name' => 'editing', 'items' => array('Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt')),
        //    array('name' => 'forms', 'items' => array('Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField')),
        //    array('name' => 'basicstyles', 'items' => array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat')),
        //    array('name' => 'paragraph', 'items' => array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl')),
        //    array('name' => 'links', 'items' => array('Link', 'Unlink', 'Anchor')),
        //    array('name' => 'insert', 'items' => array('Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe')),
        //    array('name' => 'styles', 'items' => array('Styles', 'Format', 'Font', 'FontSize')),
        //    array('name' => 'colors', 'items' => array('TextColor', 'BGColor')),
        //    array('name' => 'tools', 'items' => array('Maximize', 'ShowBlocks', '-', 'About')),
        //),
        //'toolbar_Basic' => array(
        //    array('Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About'),
        //),
        'toolbar_Full' => array(
            array('name' => 'tools', 'items' => array('Source', 'Maximize', 'ShowBlocks')),
            array('name' => 'clipboard', 'items' => array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo')),
            array('name' => 'basicstyles', 'items' => array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat')),
            array('name' => 'paragraph', 'items' => array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock')),
            array('name' => 'links', 'items' => array('Link', 'Unlink', 'Anchor')),
            array('name' => 'insert', 'items' => array('Image', 'Table', 'HorizontalRule', 'SpecialChar')),
            array('name' => 'styles', 'items' => array('Format')),
        ),
        'toolbar_Basic' => array(
            array('Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink'),
        ),
        'toolbar' => 'Full',
        'height' => '400px',
        'width' => '100%',
    );

    /**
     *
     */
    public function init()
    {
        $baseUrl = app()->assetManager->publish(Yii::getPathOfAlias('vendor.cornernote.ckeditor-assets.ckeditor'), false, -1, YII_DEBUG);
        $clientScript = Yii::app()->clientScript;
        $clientScript->registerScriptFile($baseUrl . '/ckeditor.js');
        $clientScript->registerScriptFile($baseUrl . '/adapters/jquery.js');

        $this->config = CMap::mergeArray($this->config, $this->defaultConfig);
        $clientScript->registerScript($this->id, '$("' . $this->selector . '").ckeditor(' . json_encode($this->config) . ');', CClientScript::POS_READY);

        parent::init();
    }

}
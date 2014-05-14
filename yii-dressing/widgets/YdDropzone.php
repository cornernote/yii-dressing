<?php

/**
 * Yii extension to the drag n drop HTML5 file upload Dropzone.js
 * For more info, see @link http://www.dropzonejs.com/
 *
 * @link https://github.com/subdee/yii-dropzone
 *
 * @author Konstantinos Thermos
 *
 * @copyright
 * Copyright (c) 2013 Konstantinos Thermos
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT
 * LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
 * NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 */
class YdDropzone extends CWidget
{
    /**
     * @var string The name of the file field
     */
    public $id = 'dropzone';

    /**
     * @var array
     */
    public $htmlOptions = array();

    /**
     * @var string The name of the file field
     */
    public $name = false;

    /**
     * @var CModel The model for the file field
     */
    public $model = false;

    /**
     * @var string The attribute of the model
     */
    public $attribute = false;

    /**
     * @var array An array of options that are supported by Dropzone
     */
    public $options = array();

    /**
     * @var string The URL that handles the file upload
     */
    public $url = false;

    /**
     * @var array An array of supported MIME types
     */
    public $mimeTypes = array();

    /**
     * @var string
     */
    public $onAddedFile = false;

    /**
     * @var string Called whenever a file is removed from the list. You can listen to this and delete the file from your server if you want to.
     */
    public $onRemovedFile = false;

    /**
     * @var string Receives an array of files and gets called whenever files are dropped or selected.
     */
    public $onSelectedFiles = false;

    /**
     * @var string When the thumbnail has been generated. Receives the dataUrl as second parameter.
     */
    public $onThumbnail = false;

    /**
     * @var string An error occured. Receives the errorMessage as second parameter and if the error was due to the XMLHttpRequest the xhr object as third.
     */
    public $onError = false;

    /**
     * @var string When a file gets processed (since there is a queue not all files are processed immediately).
     */
    public $onProcessing = false;

    /**
     * @var string Gets called periodically whenever the file upload progress changes.
     * Gets the progress parameter as second parameter which is a percentage (0-100) and the bytesSent parameter as
     * third which is the number of the bytes that have been sent to the server.  When an upload finishes dropzone
     * ensures that uploadprogress will be called with a percentage of 100 at least once.
     */
    public $onUploadProgress = false;

    /**
     * @var string Called just before each file is sent. Gets the xhr object and the formData objects as second and
     * third parameters, so you can modify them (for example to add a CSRF token) or add additional data.
     */
    public $onSending = false;

    /**
     * @var string The file has been uploaded successfully. Gets the server response as second argument.
     */
    public $onSuccess = false;

    /**
     * @var string Called when the upload was either successful or erroneous.
     */
    public $onComplete = false;

    /**
     * @var string Called when a file upload gets canceled.
     */
    public $onCanceled = false;

    /**
     * @var string Called when the number of files accepted exceeds the maxFiles limit.
     */
    public $onMaxFilesExceeded = false;

    /**
     * @var bool If we should register the dropzone.css styles.
     */
    public $registerDropzoneCss = true;

    /**
     * Create a div and the appropriate Javascript to make the div into the file upload area
     */
    public function run()
    {
        if (!$this->url)
            $this->url = Yii::app()->getRequest()->getRequestUri();

        $this->htmlOptions['id'] = $this->id;
        $this->htmlOptions['class'] = isset($this->htmlOptions['class']) ? $this->htmlOptions['class'] . ' dropzone' : 'dropzone';

        echo CHtml::openTag('div', $this->htmlOptions) . CHtml::closeTag('div');

        if (!$this->name && ($this->model && $this->attribute) && $this->model instanceof CModel)
            $this->name = CHtml::activeName($this->model, $this->attribute);

        $this->mimeTypes = CJavaScript::encode($this->mimeTypes);

        $callbacks = array(
            "this.on('addedfile',function(file){{$this->onAddedFile}});",
            "this.on('removedfile',function(file){{$this->onRemovedFile}});",
            "this.on('selectedfiles',function(files){{$this->onSelectedFiles}});",
            "this.on('thumbnail',function(file, dataUrl){{$this->onThumbnail}});",
            "this.on('error',function(file, errorMessage, xhr){{$this->onError}});",
            "this.on('processing',function(file){{$this->onProcessing}});",
            "this.on('uploadprogress',function(file, progress, bytesSent){{$this->onUploadProgress}});",
            "this.on('sending',function(file, xhr, formData){{$this->onSending}});",
            "this.on('success',function(file, response){{$this->onSuccess}});",
            "this.on('complete',function(file){{$this->onComplete}});",
            "this.on('canceled',function(file){{$this->onCanceled}});",
            "this.on('maxfilesexceeded',function(file){{$this->onMaxFilesExceeded}});",
        );

        $options = CMap::mergeArray(array(
            'url' => $this->url,
            'parallelUploads' => 1,
            'paramName' => $this->name,
            //'accept' => "js:function(file, done){if(jQuery.inArray(file.type,{$this->mimeTypes}) == -1 ){done('File type not allowed.');}else{done();}}",
            'init' => 'js:function(){' . implode(' ', $callbacks) . '}'
        ), $this->options);

        $options = CJavaScript::encode($options);

        $script = "Dropzone.options.{$this->id} = {$options}";

        $this->registerAssets();
        Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->getId(), $script, CClientScript::POS_END);
    }

    /**
     *
     */
    private function registerAssets()
    {
        $cs = Yii::app()->getClientScript();
        $baseUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('dressing.assets.dropzone'), true, -1, YII_DEBUG);
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($baseUrl . '/js/dropzone.js', CClientScript::POS_END);
        $cs->registerCssFile($baseUrl . '/css/dropzone.css');
        $cs->registerCssFile($baseUrl . '/css/basic.css');
        if ($this->registerDropzoneCss) {
            $cs->registerCssFile($baseUrl . '/css/dropzone.css');
        }
    }

}

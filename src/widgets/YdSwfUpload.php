<?php
/**
 * Class YdSwfUpload
 */
class YdSwfUpload extends CWidget
{
    /**
     * @var
     */
    public $jsHandlerUrl;
    /**
     * @var array
     */
    public $postParams = array();
    /**
     * @var array
     */
    public $config = array();

    /**
     *
     */
    public function run()
    {
        $assets = vp() . '/swfupload';
        $baseUrl = app()->assetManager->publish($assets, true, 1, assetCopy());
        app()->clientScript->registerScriptFile($baseUrl . '/swfupload.js', CClientScript::POS_HEAD);
        if (isset($this->jsHandlerUrl)) {
            app()->clientScript->registerScriptFile($this->jsHandlerUrl);
            unset($this->jsHandlerUrl);
        }
        //$postParams = array('PHPSESSID'=>session_id());
        $postParams = array();
        if (isset($this->postParams)) {
            $postParams = array_merge($postParams, $this->postParams);
        }
        $config = array('post_params' => $postParams, 'flash_url' => $baseUrl . '/swfupload.swf');
        $config = array_merge($this->config, $config);
        $config = CJavaScript::encode($config);
        app()->getClientScript()->registerScript(__CLASS__, "var swfu; swfu = new SWFUpload($config);");
    }

}
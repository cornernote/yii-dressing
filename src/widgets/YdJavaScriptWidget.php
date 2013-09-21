<?php
class YdJavaScriptWidget extends CWidget
{
    public $id;
    public $position;

    public function init()
    {
        ob_start();
    }

    public function run()
    {
        // get id
        if (!$this->id) {
            $this->id = 'script-' . uniqid();
        }

        // get position
        if (!$this->position) {
            $this->position = CClientScript::POS_READY;
        }

        // get contents
        $contents = ob_get_clean();
        $contents = str_replace(array('<script>', '<script type="text/javascript">', '</script>'), '', $contents);

        // register the js script
        Yii::app()->clientScript->registerScript($this->id, $contents, $this->position);
    }
}
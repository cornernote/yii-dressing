<?php
/**
 * Class YdJavaScriptWidget
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.widgets
 */
class YdJavaScriptWidget extends CWidget
{
    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    public $position;

    /**
     *
     */
    public function init()
    {
        ob_start();
    }

    /**
     *
     */
    public function run()
    {
        // get id
        if (!$this->id) {
            $this->id = 'script-' . uniqid();
        }

        // get position
        if ($this->position === null) {
            $this->position = CClientScript::POS_READY;
        }

        // get contents
        $contents = ob_get_clean();
        $contents = str_replace(array('<script>', '<script type="text/javascript">', '</script>'), '', $contents);

        // register the js script
        Yii::app()->clientScript->registerScript($this->id, $contents, $this->position);
    }
}
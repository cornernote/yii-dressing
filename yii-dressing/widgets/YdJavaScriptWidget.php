<?php

/**
 * YdJavaScriptWidget
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 *
 * @usage
 * <?php $this->beginWidget('dressing.widgets.YdJavaScriptWidget', array('id' => 'optional_uniquie_id')); ?>
 * <script type="text/javascript">
 * ... your javascript ...
 * </script>
 * <?php $this->endWidget(); ?>
 *
 * @package dressing.widgets
 */
class YdJavaScriptWidget extends CWidget
{

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
        // get position
        if ($this->position === null) {
            $this->position = CClientScript::POS_READY;
        }

        // get contents
        $contents = ob_get_clean();
        $contents = str_replace(array('<script>', '<script type="text/javascript">', '</script>'), '', $contents);
        //just echo the script
        if ($this->position ==-1){
            echo $contents;
        }
        else{
            // register the js script
            Yii::app()->clientScript->registerScript($this->id, $contents, $this->position);
        }

    }
    
}
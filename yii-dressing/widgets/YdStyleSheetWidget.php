<?php

/**
 * YdStyleSheetWidget
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.widgets
 */
class YdStyleSheetWidget extends CWidget
{
    /**
     * @var
     */
    public $id;

    /**
     * @var
     */
    public $media;

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
            $this->id = 'css-' . uniqid();
        }

        // get contents
        $contents = ob_get_clean();
        $contents = str_replace(array('<style>', '</style>'), '', $contents);

        // register the js script
        Yii::app()->clientScript->registerCss($this->id, $contents, $this->media);
    }
}
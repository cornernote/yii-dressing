<?php

/**
 * Class YdWebController
 *
 * @mixin YdWebControllerBehavior
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.components
 */
class YdWebController extends YdController
{

    /**
     *
     */
    public function init()
    {
        $this->layout = Yii::app()->dressing->defaultLayout;
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array(
            'webController' => array(
                'class' => 'dressing.behaviors.YdWebControllerBehavior',
            ),
        );
    }

}

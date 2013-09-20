<?php
/**
 * @var $this WebController
 */

if (Yii::app()->theme)
    $this->renderPartial('/layouts/_theme_scripts');

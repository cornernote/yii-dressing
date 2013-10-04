<?php
/**
 * Built-in client script packages.
 *
 * Please see {@link CClientScript::packages} for explanation of the structure
 * of the returned array.
 *
 * @var YiiDressing $this
 *
 * @author Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */
return array(
    'datepicker' => array(
        'depends' => array('jquery'),
        'baseUrl' => $this->enableCdn ? '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.1.3/' : $this->getAssetsUrl().'/font-awesome/',
        'css' => array($this->minify ? 'css/bootstrap-datepicker.min.css' : 'css/bootstrap-datepicker.css'),
        'js' => array($this->minify ? 'js/bootstrap-datepicker.min.js' : 'js/bootstrap-datepicker.js')
    ),
);

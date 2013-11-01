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
    'signature-pad' => array(
        'depends' => array('jquery'),
        'baseUrl' => $this->getAssetsUrl() . '/signature-pad/',
        'css' => array($this->minify ? 'jquery.signaturepad.yii-dressing.min.css' : 'jquery.signaturepad.yii-dressing.css'),
        'js' => array($this->minify ? 'jquery.signaturepad.min.js' : 'jquery.signaturepad.js')
    ),
    'jquery-cluetip' => array(
        'depends' => array('jquery'),
        'baseUrl' => $this->getAssetsUrl() . '/jquery-cluetip/',
        'css' => array('jquery.cluetip.css'),
        'js' => array(
			'lib/jquery.hoverIntent.js',
			$this->minify ? 'jquery.cluetip.min.js' : 'jquery.cluetip.js',
		)
    ),
);

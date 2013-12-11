<?php
/**
 * @var $this EmailSpoolController
 * @var $emailSpool YdEmailSpool
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
Yii::app()->user->setState('index.emailSpool', Yii::app()->request->requestUri);
$this->pageTitle = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->renderPartial('/emailSpool/_menu');

echo '<div class="spacer">';
if (Yii::app()->user->getState('index.emailSpool') != Yii::app()->createUrl('/emailSpool/index')) {
    //echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('dressing', 'Reset Filters'),
        'url' => array('/emailSpool/index'),
    ));
}
echo '</div>';

// grid
$this->renderPartial('/emailSpool/_grid', array('emailSpool' => $emailSpool));

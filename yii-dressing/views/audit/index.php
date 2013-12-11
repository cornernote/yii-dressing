<?php
/**
 * @var $this AuditController
 * @var $audit YdAudit
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
Yii::app()->user->setState('index.audit', Yii::app()->request->requestUri);
$this->pageTitle = Yii::t('dressing', 'Audits');

$this->renderPartial('/audit/_menu');

echo '<div class="spacer">';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Search'),
    'htmlOptions' => array('class' => 'audit-grid-search'),
    'toggle' => true,
));
if (Yii::app()->user->getState('index.audit') != Yii::app()->createUrl('/audit/index')) {
    echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('dressing', 'Reset Filters'),
        'url' => array('/audit/index'),
    ));
}
echo '</div>';

// search
$this->renderPartial('/audit/_search', array(
    'audit' => $audit,
));

// grid
$this->renderPartial('/audit/_grid', array(
    'audit' => $audit
));
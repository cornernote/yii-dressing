<?php
/**
 * @var $this YdAttachmentController
 * @var $attachment YdAttachment
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

Yii::app()->user->setState('index.attachment', Yii::app()->request->requestUri);
$this->pageTitle = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->menu = SiteMenu::getItemsFromMenu(SiteMenu::MENU_MAIN);

echo '<div class="spacer">';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Create') . ' ' . $this->getName(),
    'url' => array('/attachment/create'),
    'type' => 'primary',
    'htmlOptions' => array('data-toggle' => 'modal-remote'),
));
echo ' ';
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('dressing', 'Search'),
    'htmlOptions' => array('class' => 'attachment-grid-search'),
    'toggle' => true,
));
if (Yii::app()->user->getState('index.attachment') != Yii::app()->createUrl('/attachment/index')) {
    echo ' ';
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('dressing', 'Reset Filters'),
        'url' => array('/attachment/index'),
    ));
}
echo '</div>';

// search
$this->renderPartial('/attachment/_search', array(
    'attachment' => $attachment,
));

// grid
$this->renderPartial('/attachment/_grid', array(
    'attachment' => $attachment,
));

<?php
/**
 * @var $this AttachmentController
 * @var $attachment YdAttachment
 */

user()->setState('index.attachment', Yii::app()->request->requestUri);
$this->pageTitle = $this->pageHeading = $this->getName() . ' ' . Yii::t('dressing', 'List');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Attachments');

$this->menu = YdMenu::getItemsFromMenu('Main');

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
$this->renderPartial('dressing.views.attachment._search', array(
    'attachment' => $attachment,
));

// grid
$this->renderPartial('dressing.views.attachment._grid', array(
    'attachment' => $attachment,
));

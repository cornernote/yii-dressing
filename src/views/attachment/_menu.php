<?php
/**
 * @var $this AttachmentController
 * @var $attachment YdAttachment
 */

// index
if ($this->action->id == 'index') {
    $this->menu = YdMenu::getItemsFromMenu('Main');
    return; // no more links
}

// create
if ($attachment->isNewRecord) {
    $this->menu[] = array(
        'label' => Yii::t('dressing', 'Create'),
        'url' => array('/attachment/create'),
    );
    return; // no more links
}

// view
$this->menu[] = array(
    'label' => Yii::t('dressing', 'View'),
    'url' => $attachment->getUrl(),
);

// others
foreach ($attachment->getMenuLinks(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

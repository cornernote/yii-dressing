<?php
/**
 * @var $this AttachmentController
 * @var $attachment Attachment
 */

// index
if ($this->action->id == 'index') {
    $this->menu = Menu::getItemsFromMenu('Main');
    return; // no more links
}

// create
if ($attachment->isNewRecord) {
    $this->menu[] = array(
        'label' => t('Create'),
        'url' => array('/attachment/create'),
    );
    return; // no more links
}

// view
$this->menu[] = array(
    'label' => t('View'),
    'url' => $attachment->getUrl(),
);

// others
foreach ($attachment->getDropdownLinkItems(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

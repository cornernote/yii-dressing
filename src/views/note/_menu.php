<?php
/**
 * @var $this NoteController
 * @var $note Note
 */

// index
if ($this->action->id == 'index') {
    $this->menu = Menu::getItemsFromMenu('Main');
    return; // no more links
}

// create
if ($note->isNewRecord) {
    $this->menu[] = array(
        'label' => t('Create'),
        'url' => array('/note/create'),
    );
    return; // no more links
}

// view
$this->menu[] = array(
    'label' => t('View'),
    'url' => $note->getUrl(),
);

// others
foreach ($note->getDropdownLinkItems(true) as $linkItem) {
    $this->menu[] = $linkItem;
}

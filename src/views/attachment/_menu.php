<?php
/**
 * @var $this AttachmentController
 * @var $attachment YdAttachment
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
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

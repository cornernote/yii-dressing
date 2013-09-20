<?php
/**
 * @var $this NoteController
 * @var $note Note
 */

// list
$this->widget('widgets.ListView', array(
    'id' => 'note-list',
    'dataProvider' => $note->search(),
    'itemView' => '_list_view',
));

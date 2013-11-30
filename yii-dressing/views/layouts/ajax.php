<?php
/**
 * @var $this YdWebController
 * @var $content
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-skeleton
 * @license http://www.gnu.org/copyleft/gpl.html
 */

if ($this->isModal) {
    echo '<div class="modal-header">';
    echo '<button type="button" class="close" data-dismiss="modal"><i class="icon-remove"></i></button>';
    echo '<h3>' . $this->pageHeading . '</h3>';
    echo '</div>';
}
else
    echo '<h3>' . $this->pageHeading . '</h3>';

echo $content;

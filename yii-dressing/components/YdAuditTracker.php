<?php
/**
 * YdAuditTracker
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 *
 * @package dressing.components
 */
class YdAuditTracker
{

    /**
     *
     */
    public function init()
    {
        YdAudit::getAudit();
    }

}
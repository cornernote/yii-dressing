<?php
/**
 * YdGlobalInit
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-skeleton
 * @license http://www.gnu.org/copyleft/gpl.html
 */
class YdGlobalInit extends CApplicationComponent
{

    /**
     *
     */
    public function init()
    {
        parent::init();

        // start the audit
        YdAudit::findCurrent();
    }
}

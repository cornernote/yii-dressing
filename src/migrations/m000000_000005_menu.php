<?php
/**
 * Class m000000_000005_menu
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */
class m000000_000005_menu extends YdDbMigration
{
    /**
     *
     */
    function safeUp()
    {
        $this->import('m000000_000005_menu.sql');
    }
}
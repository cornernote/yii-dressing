<?php
/**
 * Class m000000_000004_email
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */
class m000000_000004_email extends YdDbMigration
{
    /**
     *
     */
    function safeUp()
    {
        $this->import('m000000_000004_email.sql');
    }
}
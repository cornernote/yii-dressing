<?php
/**
 * Class m000000_000001_basics
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
class m000000_000001_basics extends YdDbMigration
{
    /**
     *
     */
    function safeUp()
    {
        $this->import('m000000_000001_basics.sql');
    }
}